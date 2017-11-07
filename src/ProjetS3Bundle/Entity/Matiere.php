<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="MATIERE", indexes={@ORM\Index(name="FK_CARACTERISER", columns={"IDFORMATION"})})
 * @ORM\Entity
 */
class Matiere
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IDMATIERE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmatiere;

    /**
     * @var string
     *
     * @ORM\Column(name="COEF", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $coef;

    /**
     * @var string
     *
     * @ORM\Column(name="NOMMATIERE", type="string", length=50, nullable=true)
     */
    private $nommatiere;

    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDFORMATION", referencedColumnName="IDFORMATION")
     * })
     */
    private $idformation;


}

