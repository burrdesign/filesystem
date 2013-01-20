<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Controller für die Header-Ausgabe (in Abhängigkeit des Login-Status)
	 **/

	switch($_SESSION['login']['type']){
		case "user":
			//Benutzer ist angemeldet
			include($_SERVER['DOCUMENT_ROOT']."core/view/user_header.php");
		default:
			//Gast
			include($_SERVER['DOCUMENT_ROOT']."core/view/guest_header.php");
	}

?>