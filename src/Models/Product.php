<?php

namespace App\Models;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
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
    protected string $name;
    /**
     * @ORM\Column(type="string")
     */
    protected string $description;
    /**
     * @ORM\Column(type="integer")
     */
    protected string $price;
    /**
     * @ORM\Column(type="integer")
     */
    protected string $owner;

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

//    /**
//     * Many products have One user.
//     * @ManyToOne(targetEntity="User")
//     * @JoinColumn(name="owner", referencedColumnName="id")
//     */
//    protected $user;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return string
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param $owner
     * @return void
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
