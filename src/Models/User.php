<?php

namespace App\Models;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;
    /**
     * @ORM\Column(type="string")
     */
    protected string $firstName;
    /**
     * @ORM\Column(type="string")
     */
    protected string $lastName;
    /**
     * @ORM\Column(type="string")
     */
    protected string $email;
    /**
     * @ORM\Column(type="string")
     */
    protected string $password;

    /**
     * @var DateTime $createdAt
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected DateTime $createdAt;

    /**
     * @var DateTime $updatedAt
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected DateTime $updatedAt;

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPostPersist()
    {
        $this->updatedAt = new DateTime("now");
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function toArray() {
        return get_object_vars($this);
    }
}