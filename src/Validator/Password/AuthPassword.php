<?php
declare(strict_types=1);
namespace App\Validator\Password;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AuthPassword extends Constraint
{
    public $message = 'To powinno byc Twoje haslo';
}
