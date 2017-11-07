<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seance
 *
 * @ORM\Table(name="SEANCE", indexes={@ORM\Index(name="FK_ASSOCIER", columns={"IDMATIERE"}), @ORM\Index(name="FK_DONNER", columns={"IDPROFESSEUR"}), @ORM\Index(name="FK_LOCALISER", columns={"IDSALLE"}), @ORM\Index(name="FK_SUIVRE", columns={"IDGROUPE"})})
 * @ORM\Entity
 */
class Seance
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IDSEANCE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idseance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATEDEBUT", type="date", nullable=false)
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATEFIN", type="date", nullable=true)
     */
    private $datefin;

    /**
     * @var \Matiere
     *
     * @ORM\ManyToOne(targetEntity="Matiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDMATIERE", referencedColumnName="IDMATIERE")
     * })
     */
    private $idmatiere;

    /**
     * @var \Professeur
     *
     * @ORM\ManyToOne(targetEntity="Professeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDPROFESSEUR", referencedColumnName="IDPROFESSEUR")
     * })
     */
    private $idprofesseur;

    /**
     * @var \Salle
     *
     * @ORM\ManyToOne(targetEntity="Salle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDSALLE", referencedColumnName="IDSALLE")
     * })
     */
    private $idsalle;

    /**
     * @var \Groupe
     *
     * @ORM\ManyToOne(targetEntity="Groupe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDGROUPE", referencedColumnName="IDGROUPE")
     * })
     */
    private $idgroupe;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Etudiant", inversedBy="idseance")
     * @ORM\JoinTable(name="etreabsent",
     *   joinColumns={
     *     @ORM\JoinColumn(name="IDSEANCE", referencedColumnName="IDSEANCE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="IDETUDIANT", referencedColumnName="IDETUDIANT")
     *   }
     * )
     */
    private $idetudiant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idetudiant = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

