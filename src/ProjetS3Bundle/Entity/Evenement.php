<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="EVENEMENT", indexes={@ORM\Index(name="FK_AJOUTER", columns={"IDSECRETAIRE"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IDEVENNEMENT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevennement;

    /**
     * @var string
     *
     * @ORM\Column(name="NOMEVENEMENT", type="string", length=50, nullable=true)
     */
    private $nomevenement;

    /**
     * @var string
     *
     * @ORM\Column(name="NUMERO", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATEPUBLICATION", type="date", nullable=true)
     */
    private $datepublication;

    /**
     * @var \Secretaire
     *
     * @ORM\ManyToOne(targetEntity="Secretaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDSECRETAIRE", referencedColumnName="IDSECRETAIRE")
     * })
     */
    private $idsecretaire;


}

