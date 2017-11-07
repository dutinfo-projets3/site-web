<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table(name="GROUPE")
 * @ORM\Entity
 */
class Groupe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IDGROUPE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idgroupe;

    /**
     * @var string
     *
     * @ORM\Column(name="NUMERO", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $numero;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Etudiant", inversedBy="idgroupe")
     * @ORM\JoinTable(name="appartient",
     *   joinColumns={
     *     @ORM\JoinColumn(name="IDGROUPE", referencedColumnName="IDGROUPE")
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

