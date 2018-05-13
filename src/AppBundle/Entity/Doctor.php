<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="doctors")
 */
class Doctor
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $RPPS;
    
    public function setProperties($firstName, $lastName, $RPPS)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->RPPS = $RPPS;
    }
    
}