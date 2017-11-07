<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table(name="SALLE")
 * @ORM\Entity
 */
class Salle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IDSALLE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsalle;

    /**
     * @var string
     *
     * @ORM\Column(name="NUMERO", type="decimal", precision=8, scale=0, nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="BATIMENT", type="string", length=50, nullable=false)
     */
    private $batiment;


}

