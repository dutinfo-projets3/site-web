<?php

namespace ProjetS3Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjetS3Bundle:Web:index.html.twig', array("connected" => false));
    }

    public function loginAction() {
    	return $this->render('ProjetS3Bundle:Web:login.html.twig', array("connected" => false));
    }

}
