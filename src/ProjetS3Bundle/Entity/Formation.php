<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table(name="FORMATION")
 * @ORM\Entity
 */
class Formation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IDFORMATION", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idformation;

    /**
     * @var string
     *
     * @ORM\Column(name="NUMERO", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="DUREE", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $duree;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Etudiant", inversedBy="idformation")
     * @ORM\JoinTable(name="suivre_semestre",
     *   joinColumns={
     *     @ORM\JoinColumn(name="IDFORMATION", referencedColumnName="IDFORMATION")
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

