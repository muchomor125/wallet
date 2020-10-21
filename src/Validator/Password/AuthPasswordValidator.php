<?php
declare(strict_types=1);

namespace App\Validator\Password;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AuthPasswordValidator extends ConstraintValidator
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param AuthPassword $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if(empty($value)){
            return;
        }

        if (! $this->passwordIsCorrect($value)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }

    private function passwordIsCorrect($value): bool
    {
        return $this->passwordEncoder->isPasswordValid($this->tokenStorage->getToken()->getUser(),$value);
    }
}
