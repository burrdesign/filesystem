<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe der Dateiinformationen in der Slider-Hauptbox
	 */
	
	$root = getRoot();
	$sep = getRootSep();

	$reqpath = $_REQUEST['path'];
	$filepath = $_SERVER['DOCUMENT_ROOT']."/files/".$reqpath;
	
	$file = array();
	$sql = new SqlManager();
	$sql->setQuery("
		SELECT * FROM datei
		WHERE Datei_Speicherort = '{{path}}'
		LIMIT 1");
	$sql->bindParam("{{path}}", $filepath);
	$file = $sql->result();
	
	echo "<pre>";
	print_r($file);
	echo "</pre>";

