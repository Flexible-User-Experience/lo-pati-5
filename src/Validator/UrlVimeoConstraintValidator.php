<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Contracts\Translation\TranslatorInterface;

class UrlVimeoConstraintValidator extends ConstraintValidator
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof UrlVimeoConstraint) {
            throw new UnexpectedTypeException($constraint, UrlVimeoConstraint::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
        if (!preg_match('/^https:\/\/vimeo.com\/\d{9}/', $value, $matches)) {
            $this->context->buildViolation($this->translator->trans($constraint->message))
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
