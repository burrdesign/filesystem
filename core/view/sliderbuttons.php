<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe der Actionbuttons im Slider
	 **/
	 
	$_TYPE = getActionType($_POST, $_GET);
	
	$root = getRoot();
	$sep = getRootSep();
	$reqpath = $_REQUEST['path'];
	
	echo "<div class='slider_actions'>";

	if($_TYPE == "DIR"){
		echo "
			<a class='button_newdir' href='{$root}{$reqpath}{$sep}action=newDir'><span class='icon-plus-alt'></span> Neues Verzeichnis</a>
			<a class='button_newfile' href='{$root}{$reqpath}{$sep}action=newFile'><span class='icon-plus-alt'></span> Neue Datei</a>
			";
	} elseif($_TYPE == "NEWDIR" || $_TYPE == "NEWFILE"){
		echo "
			<a class='button_back' href='{$root}{$reqpath}'><span class='icon-x-altx-alt'></span> Zur&uuml;ck zur &Uuml;bersicht</a>
			";
	}
	
	echo "</div>";