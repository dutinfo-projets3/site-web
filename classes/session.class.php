<?php

/**
 * Classe d'exception associée aux problèmes de session
 */
class SessionException extends Exception {

}

/**
 * Classe associée à la gestion de la session
 */

class Session {
	/**
	* Démarrer une session
	*
	* @see session_status()
	* @see headers_sent($file, $line)
	* @see session_start()
	*
	* @throws SessionException si la session ne peut être démarrée
	* @throws RuntimeException si le résultat de session_status() est incohérent
	*
	* @return void
	*/
	static public function start() {
		if(session_status() == PHP_SESSION_DISABLED){
			throw new SessionException("Session déja ouverte");
		} else if(session_status() == PHP_SESSION_NONE){
			$start = session_start();
		} else if(session_status() != PHP_SESSION_DISABLED && session_status() != PHP_SESSION_NONE && session_status() != PHP_SESSION_ACTIVE && headers_sent() == false){
			throw new RuntimeException("Statut incohérent");
		}
	}
}

?>
