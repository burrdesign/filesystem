<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Hier werden alle Grundklassen, Grundfunktionen und absolute Variablen eingebunden
	 **/
	 
	function getActionType($post, $get){
		//Parameter überprüfen
		if(!is_array($post) || !is_array($get)) die("<pre>getActionType: Nicht-Array übergeben!</pre>");
		
		//Request-Array erstellen
		$request = array_merge($post, $get);
		
		//Actiontyp ermitteln
		$type = "";
		if(isset($request['s'])){
			$type = "SEARCH";
		} elseif(is_file($_SERVER['DOCUMENT_ROOT']."files/".$request['path'])){
			$type = "FILE";
		} else {
			$type = "DIR";
		}
		
		//ermittelten Typ zurückgeben
		return $type;
	}
	
	function getRoot(){
		//ist die .htaccess Umleitung aktiv?
		if(strpos($_SERVER['REQUEST_URI'],"/tree") !== false && strpos($_SERVER['REQUEST_URI'],"/tree") == 0){
			$root = "/tree/";
		} else {
			$root = "?path=";
		}
		
		//ermittelte Root-Variable zurückgeben
		return $root;
	}
	 
?>