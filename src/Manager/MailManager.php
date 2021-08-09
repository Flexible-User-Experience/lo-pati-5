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
    private string $emailAddressTest1;
    private string $emailAddressTest2;
    private string $emailAddressTest3;

    public function __construct(MailerInterface $mailer, string $customerName, string $customerEmail, string $emailAddressTest1, string $emailAddressTest2, string $emailAddressTest3)
    {
        $this->mailer = $mailer;
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
        $this->emailAddressTest1 = $emailAddressTest1;
        $this->emailAddressTest2 = $emailAddressTest2;
        $this->emailAddressTest3 = $emailAddressTest3;
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
}
