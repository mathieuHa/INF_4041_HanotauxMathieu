<?php

namespace MHStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="MHStoreBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(name="credit", type="float")
     */
    private $credit;

    /**
     * @ORM\OneToMany(targetEntity="MHStoreBundle\Entity\Product", mappedBy="buyer")
     */
    private $purchases;

    /**
    * @ORM\OneToMany(targetEntity="MHStoreBundle\Entity\Product", mappedBy="seller")
    */
    private $sales;




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
     * Set credit
     *
     * @param float $credit
     *
     * @return User
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get credit
     *
     * @return float
     */
    public function getCredit()
    {
        return $this->credit;
    }

    public function __construct()
    {
        parent::__construct();
        $this->credit = 0;
    }

    /**
     * Add purchase
     *
     * @param \MHStoreBundle\Entity\Product $purchase
     *
     * @return User
     */
    public function addPurchase(\MHStoreBundle\Entity\Product $purchase)
    {
        $this->purchases[] = $purchase;

        return $this;
    }

    /**
     * Remove purchase
     *
     * @param \MHStoreBundle\Entity\Product $purchase
     */
    public function removePurchase(\MHStoreBundle\Entity\Product $purchase)
    {
        $this->purchases->removeElement($purchase);
    }

    /**
     * Get purchases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * Add sale
     *
     * @param \MHStoreBundle\Entity\Product $sale
     *
     * @return User
     */
    public function addSale(\MHStoreBundle\Entity\Product $sale)
    {
        $this->sales[] = $sale;

        return $this;
    }

    /**
     * Remove sale
     *
     * @param \MHStoreBundle\Entity\Product $sale
     */
    public function removeSale(\MHStoreBundle\Entity\Product $sale)
    {
        $this->sales->removeElement($sale);
    }

    /**
     * Get sales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * Set setupDate
     *
     * @param \DateTime $setupDate
     *
     * @return User
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
     * @return User
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
}
