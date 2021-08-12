<?php

namespace App\Security;

use App\Event\UserSuccessLoginEvent;
use App\Form\Type\AdminLoginFormType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\AuthenticatorInterface;

class AdminLoginAuthenticator extends AbstractFormLoginAuthenticator implements AuthenticatorInterface
{
    private FormFactoryInterface $formFactory;
    private RouterInterface $router;
    private UserPasswordHasherInterface $passwordHasher;
    private EventDispatcherInterface $eventsDispatcher;

    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router, UserPasswordHasherInterface $passwordHasher, EventDispatcherInterface $eventsDispatcher)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->passwordHasher = $passwordHasher;
        $this->eventsDispatcher = $eventsDispatcher;
    }

    protected function getLoginUrl(): string
    {
        return $this->router->generate('admin_app_login');
    }

    public function supports(Request $request): bool
    {
        return 'admin_app_login' === $request->attributes->get('_route') && $request->isMethod(Request::METHOD_POST);
    }

    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(AdminLoginFormType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['email']
        );

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {
        return $userProvider->loadUserByUsername($credentials['email']);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): RedirectResponse
    {
        $event = new UserSuccessLoginEvent($token->getUser());
        $this->eventsDispatcher->dispatch($event, UserSuccessLoginEvent::NAME);

        return new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
    }
}
