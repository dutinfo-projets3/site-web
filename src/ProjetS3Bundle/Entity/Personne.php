<?php

namespace ProjetS3Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Personne
 *
 * @ORM\Table(name="PERSONNE")
 * @ORM\Entity
 */
class Personne implements UserInterface;
{
	/**
	* @var integer
	*
	* @ORM\Column(name="IDPERSONNE", type="integer", nullable=false)
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="IDENTITY")
	*/
	private $id;

	/**
	* @var string
	*
	* @ORM\Column(name="MOTDEPASSE", type="string", length=50, nullable=true)
	*/
	private $password;

	/**
	* @var string
	*
	* @ORM\Column(name="NOMPERS", type="string", length=50, nullable=true)
	*/
	private $nompers;

	/**
	* @var string
	*
	* @ORM\Column(name="PRENOMPERS", type="string", length=50, nullable=true)
	*/
	private $prenompers;

	/**
	* @var string
	*
	* @ORM\Column(name="ADRESSE", type="string", length=50, nullable=true)
	*/
	private $adresse;

	/**
	* @var string
	*
	* @ORM\Column(name="CODEPOSTAL", type="decimal", precision=5, scale=0, nullable=true)
	*/
	private $codepostal;

	/**
	* @var string
	*
	* @ORM\Column(name="URLIMAGE", type="string", length=50, nullable=true)
	*/
	private $urlimage;

	/**
	* @var string
	*
	* @ORM\Column(name="VILLE", type="string", length=50, nullable=true)
	*/
	private $ville;

	/**
	* @var string
	*
	* @ORM\Column(name="NOMUTILISATEUR", type="string", length=8, nullable=true)
	*/
	private $username;

	private $roles;

	public function __construct(){
		$this->roles = array("ROLE_USER");
	}

	public function getUsername(){
		return $this->username;
	}

	public function getPassword(){
		return $this->passsword;
	}

	public function getSalt(){
		return $this->salt;
	}

	public function getRoles(){
		return $this->roles;
	}

	public function eraseCredentials(){}

	public function serialize(){
		return serialize(
			array(
				$this->id,
				$this->username,
				$this->password
			)
		);
	}

	public function unserialize($serialized ){
		list(
			$this->id,
			$this->username,
			$this->password
		) = unserialize($serialized);
	}

}

