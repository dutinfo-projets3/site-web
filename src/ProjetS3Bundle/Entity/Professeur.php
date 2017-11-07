<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professeur
 *
 * @ORM\Table(name="PROFESSEUR")
 * @ORM\Entity
 */
class Professeur
{
    /**
     * @var \Personne
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDPROFESSEUR", referencedColumnName="IDPERSONNE")
     * })
     */
    private $idprofesseur;


}

