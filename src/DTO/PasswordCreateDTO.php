<?php
declare(strict_types=1);
namespace App\DTO;
use App\Validator\Password\AuthPassword;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordCreateDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max="180",
     *     maxMessage="Podana wartość jest za długa (max.180 znaków)."
     * )
     */
    private $login = null;


    /**
     * @var string|null The hashed password
     * @Assert\NotBlank()
     */
    private $password = null;


    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max="180",
     *     maxMessage="Podana wartość jest za długa (max.180 znaków)."
     * )
     */
    private $webAddress = null;

    /**
     * @Assert\Length(
     *     max="180",
     *     maxMessage="Podana wartość jest za długa (max.180 znaków)."
     * )
     */
    private $description = null;

    /**
     * @Assert\Length(
     *     max="180",
     *     maxMessage="Podana wartość jest za długa (max.180 znaków)."
     * )
     * @AuthPassword()
     */
    private $userPassword = null;

    /**
     * @return null
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param null $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return null
     */
    public function getWebAddress()
    {
        return $this->webAddress;
    }

    /**
     * @param null $webAddress
     */
    public function setWebAddress($webAddress): void
    {
        $this->webAddress = $webAddress;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * @param null $userPassword
     */
    public function setUserPassword($userPassword): void
    {
        $this->userPassword = $userPassword;
    }

}
