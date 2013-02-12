<?php

	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 12.2.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen: 
	 * F�hrt die Actions vor der Ausgabe aus, dadurch kann hier bei Bedarf
	 * auch der Ausgabetyp ge�ndert werden.
	 * Au�erdem k�nnen hier Messages gesetzt werden, die dann im Seitenkopf
	 * ausgegeben werden. Dazu dient das Array $message[TYP] = NACHRICHT
	 **/
	 
	$message = array();
	 
	if($_REQUEST['action'] == 'createDir'){
	
		/**
		 * Pfad pr�fen, ob Verzeichnis bereits existiert,
		 * andernfalls anlegen
		 **/
	
		$filepath = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $_REQUEST['path'] . $_REQUEST['dirname'];
		if(is_dir($filepath)){
			$message['error'] = "Verzeichnis existiert bereits!";
			$_GET['action'] = "newDir";
			$_POST['action'] = "newDir";
		} else {
			mkdir($filepath);
			unset($_GET['action']);
			unset($_POST['action']);
			$message['ok'] = "Verzeichnis wurde erfolgreich angelegt!";
		}
		
	} elseif($_REQUEST['action'] == 'deleteDir'){
	
		/**
		 * Pfad pr�fen, ob zu l�schendes Verzeichnis auch existiert
		 * und ob dieses Verzeichnis auch leer ist, nur dann l�schen
		 **/
	
		$filepath = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $_REQUEST['path'] . $_REQUEST['dirname'];
		if(is_dir($filepath)){
			$handle = opendir($filepath);
			$cnt = 0;
			while($r = readdir($filepath)){
				if($r != "." && $r != ".."){
					$cnt++;
				}
			}
			if($cnt == 0){
				rmdir($filepath);
				unset($_GET['action']);
				unset($_POST['action']);
				$message['ok'] = "Verzeichnis wurde erfolgreich gel&ouml;scht!";
			} else {
				$message['error'] = "Verzeichnis muss leer sein um gel&ouml;scht zu werden!";
			}
		} else {
			$message['error'] = "Verzeichnis konnte nicht gel&ouml;scht werden!";
			unset($_GET['action']);
			unset($_POST['action']);
		}
		
	} elseif($_REQUEST['action'] == 'uploadFile'){
	
		/**
		 * Pfad pr�fen, ob Verzeichnis bereits existiert,
		 * andernfalls anlegen
		 **/
	
		$filepath = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $_REQUEST['path'] . $_FILES['upload']['name'];
		if(is_file($filepath)){
			$message['error'] = "Datei existiert bereits!";
			$_GET['action'] = "newFile";
			$_POST['action'] = "newFile";
		} else {
			move_uploaded_file($_FILES['upload']['tmp_name'],$filepath);
			unset($_GET['action']);
			unset($_POST['action']);
			$message['ok'] = "Datei wurde erfolgreich hochgeladen!";
		}
	
	} elseif($_REQUEST['action'] == 'deleteFile'){
	
		/**
		 * Pfad pr�fen, ob Datei wirklich existiert, und nur dann
		 * auch l�schen (evtl. TODO: Sicherheitsabfrage)
		 **/
	
		$filepath = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $_REQUEST['path'] . $_REQUEST['filename'];
		if(!is_file($filepath)){
			$message['error'] = "Datei konnte nicht gel&ouml;scht werden!";
			unset($_GET['action']);
			unset($_POST['action']);
		} else {
			unlink($filepath);
			unset($_GET['action']);
			unset($_POST['action']);
			$message['ok'] = "Datei wurde erfolgreich gel&ouml;scht!";
		}
	
	}