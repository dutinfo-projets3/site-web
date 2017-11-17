<?php

class TwigLoader{

	/**
	 * Instance de Twig
	 */
	private $twig;

	/**
	 * Instance de TwigLoader
	 */
	private static $twloader;

	private function __construct(){
		$loader = new \Twig_Loader_Filesystem(__DIR__ . '/../twigs');
		$this->twig = new \Twig_Environment($loader);
	}

	public static function getInstance(){
		if (TwigLoader::$twloader == null){
			TwigLoader::$twloader = new TwigLoader();
		}
		return TwigLoader::$twloader;
	}

	/**
	 * Retourne le HTML du Twig
	 */
	public function render(string $twigname, array $parameters){
		if (Utilisateur::isConnected()){
			$parameters["connected"] = true;
			$parameters["form"] = Utilisateur::createFromSession()->createLogoutForm();
		} else {
			$err = isset($_GET['err']) ? $_GET['err'] : null;
			$parameters["connected"] = false;
			$parameters["form"]      = Utilisateur::createLoginForm($err);
		}

		return $this->twig->render($twigname, $parameters);
	}

}
