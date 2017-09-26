<?php

namespace MHStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="MHStoreBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity="MHStoreBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="MHStoreBundle\Entity\User", inversedBy="sales")
     */
    private $seller;

    /**
     * @ORM\ManyToOne(targetEntity="MHStoreBundle\Entity\User", inversedBy="purchases")
     */
    private $buyer;

    /**
     * @var bool
     *
     * @ORM\Column(name="sold", type="boolean")
     */
    private $sold;

    /**
     * @ORM\Column(name="setup_date", type="datetime")
     */
    private $setupDate;

    /**
     * @ORM\Column(name="sold_date", type="datetime", nullable=true)
     */
    private $soldDate;





    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    public function __construct()
    {
        $this->sold = false;
        $this->setSetupDate(new \DateTime());
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set seller
     *
     * @param \MHStoreBundle\Entity\User $seller
     *
     * @return Product
     */
    public function setSeller(\MHStoreBundle\Entity\User $seller = null)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get seller
     *
     * @return \MHStoreBundle\Entity\User
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Set buyer
     *
     * @param \MHStoreBundle\Entity\User $buyer
     *
     * @return Product
     */
    public function setBuyer(\MHStoreBundle\Entity\User $buyer = null)
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * Get buyer
     *
     * @return \MHStoreBundle\Entity\User
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Set sold
     *
     * @param boolean $sold
     *
     * @return Product
     */
    public function setSold($sold)
    {
        $this->sold = $sold;

        return $this;
    }

    /**
     * Get sold
     *
     * @return boolean
     */
    public function getSold()
    {
        return $this->sold;
    }

    /**
     * Set setupDate
     *
     * @param \DateTime $setupDate
     *
     * @return Product
     */
    public function setSetupDate($setupDate)
    {
        $this->setupDate = $setupDate;

        return $this;
    }

    /**
     * Get setupDate
     *
     * @return \DateTime
     */
    public function getSetupDate()
    {
        return $this->setupDate;
    }

    /**
     * Set soldDate
     *
     * @param \DateTime $soldDate
     *
     * @return Product
     */
    public function setSoldDate($soldDate)
    {
        $this->soldDate = $soldDate;

        return $this;
    }

    /**
     * Get soldDate
     *
     * @return \DateTime
     */
    public function getSoldDate()
    {
        return $this->soldDate;
    }

    /**
     * Set image
     *
     * @param \MHStoreBundle\Entity\Image $image
     *
     * @return Product
     */
    public function setImage(\MHStoreBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \MHStoreBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
