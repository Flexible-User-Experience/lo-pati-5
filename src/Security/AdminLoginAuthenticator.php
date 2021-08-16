<?php

namespace App\Security;

use App\Event\UserSuccessLoginEvent;
use App\Form\Type\AdminLoginFormType;
use App\Model\AdminLogin;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

class AdminLoginAuthenticator extends AbstractLoginFormAuthenticator
{
    private UserProviderInterface $userProvider;
    private FormFactoryInterface $formFactory;
    private RouterInterface $router;
    private UserPasswordHasherInterface $passwordHasher;
    private EventDispatcherInterface $eventsDispatcher;

    public function __construct(UserProviderInterface $userProvider, FormFactoryInterface $formFactory, RouterInterface $router, UserPasswordHasherInterface $passwordHasher, EventDispatcherInterface $eventsDispatcher)
    {
        $this->userProvider = $userProvider;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->passwordHasher = $passwordHasher;
        $this->eventsDispatcher = $eventsDispatcher;
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate('admin_app_login');
    }

    public function supports(Request $request): bool
    {
        return $request->isMethod(Request::METHOD_POST) && 'admin_app_login' === $request->attributes->get('_route');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $credentials = $this->getCredentials($request);
        $user = $this->getUser($credentials, $this->userProvider);
        if (!$user) {
            throw new CustomUserMessageAuthenticationException('User not found');
        }
        $hasGoodCredentials = $this->checkCredentials($credentials, $user);
        if (!$hasGoodCredentials) {
            throw new CustomUserMessageAuthenticationException('Invalid credentials');
        }

        return new Passport(new UserBadge($credentials->getEmail()), new PasswordCredentials($credentials->getPassword()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $event = new UserSuccessLoginEvent($token->getUser());
        $this->eventsDispatcher->dispatch($event, UserSuccessLoginEvent::NAME);

        return new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
    }

    private function getCredentials(Request $request): AdminLogin
    {
        $adminLogin = new AdminLogin();
        $form = $this->formFactory->create(AdminLoginFormType::class, $adminLogin);
        $form->handleRequest($request);
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $adminLogin->getEmail(),
        );

        return $adminLogin;
    }

    private function getUser(AdminLogin $credentials, UserProviderInterface $userProvider): UserInterface
    {
        return $userProvider->loadUserByIdentifier($credentials->getEmail());
    }

    private function checkCredentials(AdminLogin $credentials, UserInterface $user): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $credentials->getPassword());
    }
}
