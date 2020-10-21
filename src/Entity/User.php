<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\User\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Password;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     "email",
 *     message="Taki użytkownik już istnieje!"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(
     *     type = "string",
     *     length = 180,
     *     unique = true
     * )
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "Wprowadź poprawny email"
     * )
     * @Assert\Length(
     *     max="180",
     *     maxMessage="Podana wartość jest za długa (max.180 znaków)."
     * )
     */
    protected $email = null;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @var string|null The hashed password
     * @Assert\NotBlank()
     * @ORM\Column(
     *     type = "string"
     * )
     */
    protected $password = null;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    protected $asHash = false;

    /**
     * * @ORM\Column(
     *     type = "string"
     * )
     */
    protected $u_salt;


    /**
     * @ORM\OneToMany(
     *     targetEntity=Password::class,
     *     mappedBy="user",
     *     cascade={"persist", "remove"}
     * )
     */
    private $passwords;

    public function __construct()
    {
        $this->password = new ArrayCollection();
    }

    public function setSalt(string $u_salt): void
    {
        $this->u_salt = $u_salt;
    }

    /**
     * @param bool $asHash
     */
    public function setAsHash(bool $asHash): void
    {
        $this->asHash = $asHash;
    }

    /**
     * @return bool
     */
    public function getAsHash(): bool
    {
        return $this->asHash;
    }

    /**
     * @return string
     */
    public function getU_Salt(): string
    {
        return $this->u_salt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = strtolower($email);
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getPassword()//: ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function addRole(string $role): void
    {
        $this->roles[] = $role;
        $this->roles = array_unique($this->roles);
    }

    public function removeRole(string $role): void
    {
        $key = array_search($role, $this->roles);
        if ($key !== false) {
            unset($this->roles[$key]);
        }
    }

    /**
     * @return mixed
     */
    public function getPasswords()
    {
        return $this->passwords;
    }

    /**
     * @param mixed $passwords
     */
    public function setPasswords($passwords): void
    {
        $this->passwords = $passwords;
    }
}
