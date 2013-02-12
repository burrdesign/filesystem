<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Controller für die Header-Ausgabe (auch in Abhängigkeit des Login-Status)
	 **/
	
	$icon = array("info" => "icon-info", "ok" => "icon-checkmark", "error" => "icon-x");
	if(is_array($message)){
		foreach($message as $type => $text){
			$iconclass = $icon[$type];
			echo "<div class='message message_{$type}'><p><span class='icon {$iconclass}'></span> {$text}</p></div>";
		}
	}

	switch($_SESSION['login']['type']){
		case "user":
			//Benutzer ist angemeldet
			include($_SERVER['DOCUMENT_ROOT']."core/view/user_header.php");
		default:
			//Gast
			include($_SERVER['DOCUMENT_ROOT']."core/view/guest_header.php");
	}