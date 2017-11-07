<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notes
 *
 * @ORM\Table(name="NOTES", indexes={@ORM\Index(name="FK_NOTER", columns={"IDMATIERE"}), @ORM\Index(name="FK_POSSEDER", columns={"IDPERSONNE"})})
 * @ORM\Entity
 */
class Notes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IDNOTE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idnote;

    /**
     * @var integer
     *
     * @ORM\Column(name="VALEUR", type="integer", nullable=false)
     */
    private $valeur;

    /**
     * @var string
     *
     * @ORM\Column(name="COEFF", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $coeff;

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
     * @var \Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDPERSONNE", referencedColumnName="IDETUDIANT")
     * })
     */
    private $idpersonne;


}

