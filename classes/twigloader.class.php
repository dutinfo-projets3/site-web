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
	public function render(string $page, string $twigname, array $parameters){
		$split = explode('-', $page);
		$parameters["page"] = $split[0];
		if(isset($split[1])){
			$parameters["subpage"] = $split[1];
		}
		if (Utilisateur::isConnected()){
			$parameters["connected"] = true;
			$parameters["form"] = Utilisateur::createFromSession()->createLogoutForm(isset($parameters['displayPanelButton']) ? $parameters['displayPanelButton'] : true);
		} else {
			$err = isset($_GET['err']) ? $_GET['err'] : null;
			$parameters["connected"] = false;
			$parameters["form"]      = Utilisateur::createLoginForm($err);
			$parameters['error'] = $err;

		}

		return $this->twig->render($twigname . '.html.twig', $parameters);
	}

}

