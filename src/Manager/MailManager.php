<?php

namespace App\Manager;

use App\Model\SendGridEmailToken;
use Exception;
use Psr\Log\LoggerInterface;
use SendGrid;
use SendGrid\Mail\From as SendGridEmailFrom;
use SendGrid\Mail\HtmlContent as SendGridEmailHtmlContent;
use SendGrid\Mail\Mail as SendGridEmail;
use SendGrid\Mail\Personalization as SendGridEmailPersonalization;
use SendGrid\Mail\Subject as SendGridEmailSubject;
use SendGrid\Mail\To as SendGridEmailTo;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class MailManager
{
    private SendGrid $sg;
    private MailerInterface $mailer;
    private RouterInterface $router;
    private LoggerInterface $logger;
    private string $customerName;
    private string $customerEmail;
    private string $emailAddressTest1;
    private string $emailAddressTest2;
    private string $emailAddressTest3;

    public function __construct(MailerInterface $mailer, RouterInterface $router, LoggerInterface $logger, string $sendGridApiKey, string $customerName, string $customerEmail, string $emailAddressTest1, string $emailAddressTest2, string $emailAddressTest3)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->logger = $logger;
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
        $this->emailAddressTest1 = $emailAddressTest1;
        $this->emailAddressTest2 = $emailAddressTest2;
        $this->emailAddressTest3 = $emailAddressTest3;
        $this->sg = new SendGrid($sendGridApiKey);
    }

    public function sendNewsletterEmailTest(string $subject, string $htmlContent): bool
    {
        $email = (new Email())
            ->from(new Address($this->customerEmail, $this->customerName))
            ->to($this->emailAddressTest1)
            ->addTo($this->emailAddressTest2)
            ->addTo($this->emailAddressTest3)
            ->subject($subject)
            ->html($htmlContent);
        try {
            $this->mailer->send($email);
            $sendingSuccessStatus = true;
        } catch (TransportExceptionInterface $e) {
            $sendingSuccessStatus = false;
        }

        return $sendingSuccessStatus;
    }

    private function sendEmail(string $subject, string $htmlContent): bool
    {
        $email = (new Email())
            ->from(new Address($this->customerEmail, $this->customerName))
            ->to('you@example.com') // TODO
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->html($htmlContent);
        try {
            $this->mailer->send($email);
            $sendingSuccessStatus = true;
        } catch (TransportExceptionInterface $e) {
            $sendingSuccessStatus = false;
        }

        return $sendingSuccessStatus;
    }

    public function sendGridBatchDelivery(string $subject, string $htmlContent, array $emailDestinationList): bool
    {
        $result = false;
        if (count($emailDestinationList) > 0) {
            try {
                // sliced recipients in portions of 100 items
                // (Sendgrid can send up to 1000 recipents per mail and 100 mails per connection)
                $chunks = array_chunk($emailDestinationList, 950);
                $from = new SendGridEmailFrom($this->customerEmail, $this->customerName);
                $to = new SendGridEmailTo($this->customerEmail, $this->customerName);
                /** @var array $chunk */
                foreach ($chunks as $chunk) {
                    // slices of 950 emails per chunk
                    $mail = new SendGridEmail($from, $to, new SendGridEmailSubject($subject), null, new SendGridEmailHtmlContent($htmlContent));
                    /** @var SendGridEmailToken $destEmail */
                    foreach ($chunk as $destEmail) {
                        $personalitzation = new SendGridEmailPersonalization();
                        $personalitzation->addTo(new SendGridEmailTo($destEmail->getEmail()));
                        $personalitzation->addSubstitution('%token%', $this->router->generate('front_app_newsletter_unsuscribe', [
                            'token' => $destEmail->getToken(),
                        ], UrlGeneratorInterface::ABSOLUTE_URL));
                        $mail->addPersonalization($personalitzation);
                    }
                    $this->sg->client->mail()->send()->post($mail);
                }
                $result = true;
            } catch (Exception $e) {
                $this->logger->error('ERROR: Sendgrid code: '.$e->getCode());
                $this->logger->error('ERROR: Sendgrid msg: '.$e->getMessage());

                $result = false;
            }
        }

        return $result;
    }
}
