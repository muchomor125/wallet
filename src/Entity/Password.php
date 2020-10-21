<?php
declare(strict_types=1);
namespace App\Entity;

use App\Repository\Password\PasswordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PasswordRepository::class)
 * )
 */
class Password
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(
     *     type = "string",
     *     length = 180,
     * )
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
     * @ORM\Column(
     *     type = "string"
     * )
     */
    private $password = null;

    /**
     * @ORM\Column(
     *     type = "string",
     *     length = 180,
     * )
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max="180",
     *     maxMessage="Podana wartość jest za długa (max.180 znaków)."
     * )
     */
    private $webAddress = null;

    /**
     * @ORM\Column(
     *     type = "string",
     *     length = 180,
     *     nullable = true
     * )
     * @Assert\Length(
     *     max="180",
     *     maxMessage="Podana wartość jest za długa (max.180 znaków)."
     * )
     */
    private $description = null;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\User",
     *     inversedBy="passwords"
     * )
     */
    private $user;

    public function __construct(
        $login,
        ?string $password,
        $webAddress,
        $description,
        $user
    ) {
        $this->login = $login;
        $this->password = $password;
        $this->webAddress = $webAddress;
        $this->description = $description;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

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
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
}
