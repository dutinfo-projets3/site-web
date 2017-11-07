<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="IMAGE", indexes={@ORM\Index(name="FK_CONTENIR", columns={"IDEVENNEMENT"})})
 * @ORM\Entity
 */
class Image
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IDIMAGE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idimage;

    /**
     * @var string
     *
     * @ORM\Column(name="URL", type="string", length=50, nullable=true)
     */
    private $url;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDEVENNEMENT", referencedColumnName="IDEVENNEMENT")
     * })
     */
    private $idevennement;


}

