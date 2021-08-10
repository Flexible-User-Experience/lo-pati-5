<?php

namespace App\Model;

class SendGridNameEmailToken extends SendGridEmailToken
{
    private string $name;

    public function __construct(string $name, string $email, string $token)
    {
        $this->name = $name;
        parent::__construct($email, $token);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
