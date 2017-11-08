<?php

namespace ProjetS3Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LoginController extends Controller
{

	/**
	 * @Route("/login", name="login")
	 */
	public function loginAction(){
		$request = $this->getRequest();
		    $session = $request->getSession();

		    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
	        $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		        } else {
	        $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			        $session->remove(SecurityContext::AUTHENTICATION_ERROR);
			    }

		        $params = array(
			        "last_username" => $session->get(SecurityContext::LAST_USERNAME),
			        "error"         => $error,
			    );

		        return $params;
	}

	/**
	 * @Route("/login_check")
	 */
	public function checkAction(){
		// Nothing
	}

	/**
	 * @Route("/logout")
	 */
	public function logoutAction(){
		// Nothing
	}
}
