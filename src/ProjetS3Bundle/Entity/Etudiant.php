<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table(name="ETUDIANT")
 * @ORM\Entity
 */
class Etudiant
{
    /**
     * @var string
     *
     * @ORM\Column(name="INE", type="string", length=50, nullable=false)
     */
    private $ine;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATEENTREE", type="date", nullable=true)
     */
    private $dateentree;

    /**
     * @var \Personne
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDETUDIANT", referencedColumnName="IDPERSONNE")
     * })
     */
    private $idetudiant;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Groupe", mappedBy="idetudiant")
     */
    private $idgroupe;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Seance", mappedBy="idetudiant")
     */
    private $idseance;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Formation", mappedBy="idetudiant")
     */
    private $idformation;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idgroupe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idseance = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idformation = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

