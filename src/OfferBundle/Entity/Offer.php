<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * Offer
 *
 * @ORM\Table(name="offer", indexes={@ORM\Index(name="offer_ibfk_1", columns={"owner_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */


class Offer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idOffer", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idoffer;

    /**
     * @var string
     *
     * @ORM\Column(name="nameOffer", type="string", length=300, nullable=false)
     */
    private $nameoffer;

    /**
     * @var string
     *
     * @ORM\Column(name="placeOffer", type="string", length=300, nullable=false)
     */
    private $placeoffer;

    /**
     * @var integer
     *
     * @ORM\Column(name="priceOffer", type="integer", nullable=false)
     */
    private $priceoffer;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionOffer", type="string", length=5000, nullable=false)
     */
    private $descriptionoffer;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOffer", type="date", nullable=false)
     */
    private $dateoffer;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumn(name="categorie_id",referencedColumnName="id")
     */
    private $categoryoffer;

    /**
     * @var integer
     *
     * @ORM\Column(name="rateOffer", type="integer", nullable=false)
     */
    private $rateoffer;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * })
     */
    private $owner;

    public function __construct()
    {
        $this->dateoffer = new \DateTime();
        $this->rateoffer = -1;
    }


    /**
     * Get idoffer
     *
     * @return integer
     */
    public function getIdoffer()
    {
        return $this->idoffer;
    }

    /**
     * Set nameoffer
     *
     * @param string $nameoffer
     *
     * @return Offer
     */
    public function setNameoffer($nameoffer)
    {
        $this->nameoffer = $nameoffer;

        return $this;
    }

    /**
     * Get nameoffer
     *
     * @return string
     */
    public function getNameoffer()
    {
        return $this->nameoffer;
    }

    /**
     * Set placeoffer
     *
     * @param string $placeoffer
     *
     * @return Offer
     */
    public function setPlaceoffer($placeoffer)
    {
        $this->placeoffer = $placeoffer;

        return $this;
    }

    /**
     * Get placeoffer
     *
     * @return string
     */
    public function getPlaceoffer()
    {
        return $this->placeoffer;
    }

    /**
     * Set priceoffer
     *
     * @param integer $priceoffer
     *
     * @return Offer
     */
    public function setPriceoffer($priceoffer)
    {
        $this->priceoffer = $priceoffer;

        return $this;
    }

    /**
     * Get priceoffer
     *
     * @return integer
     */
    public function getPriceoffer()
    {
        return $this->priceoffer;
    }

    /**
     * Set descriptionoffer
     *
     * @param string $descriptionoffer
     *
     * @return Offer
     */
    public function setDescriptionoffer($descriptionoffer)
    {
        $this->descriptionoffer = $descriptionoffer;

        return $this;
    }

    /**
     * Get descriptionoffer
     *
     * @return string
     */
    public function getDescriptionoffer()
    {
        return $this->descriptionoffer;
    }


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }


    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Offer
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set dateoffer
     *
     * @param \DateTime $dateoffer
     *
     * @return Offer
     */
    public function setDateoffer($dateoffer)
    {
        $this->dateoffer = $dateoffer;

        return $this;
    }

    /**
     * Get dateoffer
     *
     * @return \DateTime
     */
    public function getDateoffer()
    {
        return $this->dateoffer;
    }

    /**
     * Set rateoffer
     *
     * @param integer $rateoffer
     *
     * @return Offer
     */
    public function setRateoffer($rateoffer)
    {
        $this->rateoffer = $rateoffer;

        return $this;
    }

    /**
     * Get rateoffer
     *
     * @return integer
     */
    public function getRateoffer()
    {
        return $this->rateoffer;
    }

    /**
     * Set categoryoffer
     *
     * @param \OfferBundle\Entity\Categorie $categoryoffer
     *
     * @return Offer
     */
    public function setCategoryoffer(\OfferBundle\Entity\Categorie $categoryoffer = null)
    {
        $this->categoryoffer = $categoryoffer;

        return $this;
    }

    /**
     * Get categoryoffer
     *
     * @return \OfferBundle\Entity\Categorie
     */
    public function getCategoryoffer()
    {
        return $this->categoryoffer;
    }

    /**
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     *
     * @return Offer
     */
    public function setOwner(\AppBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \AppBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
