<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Controller für die Slider-Ausgabe (in Abhängigkeit des Action-Types)
	 */

	$_TYPE = getActionType($_POST, $_GET);
	
	switch($_TYPE){
		case "SEARCH":
			//Suchergebnis ausgeben
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/breadcrumb.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/search_result.php");
			echo "</div>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/sliderbuttons.php");
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
		case "NEWDIR":
			//Verzeichnis anlegen
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/breadcrumb.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/newdir.php");
			echo "</div>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/sliderbuttons.php");
			break;
		case "NEWFILE":
			//Verzeichnis anlegen
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/breadcrumb.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/newfile.php");
			echo "</div>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/sliderbuttons.php");
			break;
		case "LOGIN":
			//Loginmaske ausgeben
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/breadcrumb.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/loginform.php");
			echo "</div>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/sliderbuttons.php");
			break;		
		case "USER":
			//Benutzerliste ausgeben
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/breadcrumb.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/benutzerverwaltung.php");
			echo "</div>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/sliderbuttons.php");
			break;	
		case "EDITUSER":
			//Benutzer verwalten
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/breadcrumb.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/benutzerbearbeitung.php");
			echo "</div>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/sliderbuttons.php");
			break;	
		case "NEWUSER":
			//Benutzer anlegen
			echo "<div class='inner_box'>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/breadcrumb.php");
			include($_SERVER['DOCUMENT_ROOT']."core/view/benutzeranlegen.php");
			echo "</div>";
			include($_SERVER['DOCUMENT_ROOT']."core/view/sliderbuttons.php");
			break;	
		default:
			//404-Fehler: Unbekannte Anfrage
			echo "<div class='inner_box'><pre>404-Fehler</pre></div>";
			break;
	}