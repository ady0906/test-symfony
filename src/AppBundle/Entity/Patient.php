<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="patients")
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $dateOfBirth;
    
    /**
     * @ORM\Column(type="string", length=1)
     */
    private $gender;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $postalCode;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;
    
    public function setProperties($firstName, $lastName, $dateOfBirth, $gender, $street, $postalCode, $city)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dateOfBirth = $dateOfBirth;
        $this->gender = $gender;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
    }
    
}