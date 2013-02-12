<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 12.2.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe des Formulars zum hochladen einer neuen Datei
	 **/

	$root = getRoot();
	$sep = getRootSep();

	$reqpath = $_REQUEST['path'];
	$filepath = $_SERVER['DOCUMENT_ROOT']."files/".$reqpath;
	
	$reqname = $_REQUEST['dirname'];
	
	echo "<div class='innerbox'>";
	
	echo "
		<p>Laden Sie hier eine neue Datei hoch. Dateien werden nicht &uuml;berschrieben, achten Sie darauf das die hochgeladene Datei noch nicht auf dem Server existiert.</p>
		";
		
	echo "
		<form name='newFile' action='{$root}{$reqpath}' method='post' enctype='multipart/form-data'>
			<input type='hidden' name='action' value='uploadFile'>
			<input type='file' name='upload'>
			<input type='submit' class='submit' value='Datei hochladen'>
		</form>
		";
	
	echo "</div>";