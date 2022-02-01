<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UrlVimeoConstraint extends Constraint
{
    public string $message = 'L\'adreça de Vimeo ha de seguir sempre el mateix patró, substituint les \'X\' per números. Exemple https://vimeo.com/559673570';
}
