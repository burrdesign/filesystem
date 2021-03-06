<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Hier werden alle Grundklassen, Grundfunktionen und absolute Variablen eingebunden
	 */
	 
	function getActionType($post, $get){
		//Parameter �berpr�fen
		if(!is_array($post) || !is_array($get)) die("<pre>getActionType: Nicht-Array �bergeben!</pre>");
		
		//Request-Array erstellen
		$request = array_merge($post, $get);
		
		//Actiontyp ermitteln
		$type = "";
		if(isset($request['s'])){
			$type = "SEARCH";
		} elseif($request['action'] == "newDir"){
			$type = "NEWDIR";
		} elseif($request['action'] == "newFile"){
			$type = "NEWFILE";
		} elseif($request['action'] == "Login" && $_SESSION['login']['type'] != "user"){
			$type = "LOGIN";
		} elseif($request['action'] == "User"){
			$type = "USER";
		} elseif($request['action'] == "UserDetail" && !empty($_REQUEST['userid'])){
			$type = "EDITUSER";
		} elseif($request['action'] == "newUser"){
			$type = "NEWUSER";
		} elseif(is_file($_SERVER['DOCUMENT_ROOT']."files/".$request['path'])){
			$type = "FILE";
		} else {
			$type = "DIR";
		}
		
		//ermittelten Typ zur�ckgeben
		return $type;
	}
	
	function getRoot(){
		//ist die .htaccess Umleitung aktiv?
		if(strpos($_SERVER['REQUEST_URI'],"/tree") !== false && strpos($_SERVER['REQUEST_URI'],"/tree") == 0){
			$root = "/tree/";
		} else {
			$root = "?path=";
		}
		
		//ermittelte Root-Variable zur�ckgeben
		return $root;
	}
	
	function getRootSep(){
		//ist die .htaccess Umleitung aktiv?
		if(strpos($_SERVER['REQUEST_URI'],"/tree") !== false && strpos($_SERVER['REQUEST_URI'],"/tree") == 0){
			$sep = "?";
		} else {
			$sep = "&";
		}
		
		//und ermittelten Separator zur�ckgeben
		return $sep;
	}
	 
?>