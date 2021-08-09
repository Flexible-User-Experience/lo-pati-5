<?php

namespace App\Manager;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailManager
{
    private MailerInterface $mailer;
    private string $customerName;
    private string $customerEmail;

    public function __construct(MailerInterface $mailer, string $customerName, string $customerEmail)
    {
        $this->mailer = $mailer;
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
    }

    public function sendNewsletterEmailTest(string $subject, string $htmlContent): bool
    {
        return $this->sendEmail($subject, $htmlContent);
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
            ->text('Sending emails is fun again!') // TODO
            ->html($htmlContent);
        try {
            $this->mailer->send($email);
            $sendingSuccessStatus = true;
        } catch (TransportExceptionInterface $e) {
            $sendingSuccessStatus = false;
        }

        return $sendingSuccessStatus;
    }
}
