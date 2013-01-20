<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Controller für die Slider-Ausgabe (in Abhängigkeit des Action-Types)
	 **/

	$_TYPE = getActionType($_POST, $_GET);
	
	switch($_TYPE){
		case "SEARCH":
			//Suchergebnis ausgeben
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/search_keywords.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/search_result.php");
			echo "</div>";
			break;
		case "FILE":
			// Dateiinformationen ausgeben
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/breadcrumb.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/filedetail.php");
			echo "</div>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/sliderbuttons.php");
			break;
		case "DIR":
			//Verzeichnisbaum ausgeben
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/breadcrumb.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/filetree.php");
			echo "</div>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/sliderbuttons.php");
			break;
		default:
			//404-Fehler: Unbekannte Anfrage
			break;
	}
	
?>