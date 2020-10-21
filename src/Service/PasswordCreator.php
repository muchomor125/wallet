<?php
declare(strict_types=1);
namespace App\Service;

use App\Decoder\OwnPasswordDecoder;
use App\DTO\PasswordCreateDTO;
use App\Entity\Password;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordCreator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    private $OwnPasswordDecoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        UserPasswordEncoderInterface $passwordEncoder,
    OwnPasswordDecoder $OwnPasswordDecoder
    )
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->passwordEncoder = $passwordEncoder;
        $this->OwnPasswordDecoder = $OwnPasswordDecoder;
    }

    public function createPassword(
        PasswordCreateDTO $passwordCreateDTO
    ) {
        $password = new Password(
            $passwordCreateDTO->getLogin(),
            $this->OwnPasswordDecoder->ownEncoder($passwordCreateDTO->getPassword(),$passwordCreateDTO->getUserPassword()),
            $passwordCreateDTO->getWebAddress(),
            $passwordCreateDTO->getDescription(),
            $this->getAuthUser()
        );
        $this->entityManager->persist($password);
        $this->entityManager->flush();
    }

    private function getAuthUser(){
        return $this->tokenStorage->getToken()->getUser();
    }
}
