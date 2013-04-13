<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe der Actionbuttons im Slider
	 */
	 
	$_TYPE = getActionType($_POST, $_GET);
	
	$root = getRoot();
	$sep = getRootSep();
	$reqpath = $_REQUEST['path'];
	
	echo "<div class='slider_actions'>";

	if($_TYPE == "DIR"){
		if($_SESSION['login']['type'] == "user"){
			echo "
				<a class='button_newdir' href='{$root}{$reqpath}{$sep}action=newDir'><span class='icon-plus-alt'></span> Neues Verzeichnis</a>
				<a class='button_newfile' href='{$root}{$reqpath}{$sep}action=newFile'><span class='icon-plus-alt'></span> Neue Datei</a>
				";
		}
	} elseif($_TYPE == "FILE"){
		if($_SESSION['login']['type'] == "user"){
			$t = explode("/",$reqpath);
			$filename = $t[count($t) - 1];
			$dirname = str_replace($filename,"",$reqpath);
			
			if($rechte['Rechte_Ausfuehren'] == 1){
				echo "
					<a class='button_back' href='{$root}{$dirname}{$sep}action=deleteFile&filename={$filename}'><span class='icon-trash-fill'></span> Datei l&ouml;schen</a>
					";
			}
		}
	} elseif($_TYPE == "NEWDIR" || $_TYPE == "NEWFILE" || $_TYPE == "LOGIN"){
		echo "
			<a class='button_back' href='{$root}{$reqpath}'><span class='icon-x-altx-alt'></span> Zur&uuml;ck zur &Uuml;bersicht</a>
			";
	} elseif($_TYPE == "SEARCH"){
		echo "
			<a class='button_back' href='{$root}{$reqpath}'><span class='icon-x-altx-alt'></span> Zur&uuml;ck zur Dateiverwaltung</a>
			";
	} elseif($_TYPE == "USER"){
		echo "
			<a class='button_newdir' href='{$root}{$reqpath}{$sep}action=newUser'><span class='icon-plus-alt'></span> Neuen Benutzer</a>
			<a class='button_back' href='{$root}{$reqpath}'><span class='icon-x-altx-alt'></span> Zur&uuml;ck zur Dateiverwaltung</a>
		 	";
	} elseif($_TYPE == "EDITUSER"){
		echo "
			<a class='button_back' href='{$root}{$reqpath}{$sep}action=deleteUser&userid={$_REQUEST['userid']}'><span class='icon-trash-fill'></span> Benutzer l&ouml;schen</a>
			<a class='button_back' href='{$root}{$reqpath}{$sep}action=User'><span class='icon-x-altx-alt'></span> Zur&uuml;ck zur &Uuml;bersicht</a>
			";
	}
	
	echo "</div>";