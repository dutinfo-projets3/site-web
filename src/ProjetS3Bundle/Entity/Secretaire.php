<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secretaire
 *
 * @ORM\Table(name="SECRETAIRE")
 * @ORM\Entity
 */
class Secretaire
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATEEMBAUCHE", type="date", nullable=true)
     */
    private $dateembauche;

    /**
     * @var \Personne
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDSECRETAIRE", referencedColumnName="IDPERSONNE")
     * })
     */
    private $idsecretaire;


}

