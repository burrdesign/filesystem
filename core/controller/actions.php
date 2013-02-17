<?php

	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 12.2.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen: 
	 * Führt die Actions vor der Ausgabe aus, dadurch kann hier bei Bedarf
	 * auch der Ausgabetyp geändert werden.
	 * Außerdem können hier Messages gesetzt werden, die dann im Seitenkopf
	 * ausgegeben werden. Dazu dient das Array $message[TYP] = NACHRICHT
	 */
	 
	$message = array();
	 
	if($_REQUEST['action'] == 'createDir'){
	
		/**
		 * Pfad prüfen, ob Verzeichnis bereits existiert,
		 * andernfalls anlegen
		 */
	
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
		 * Pfad prüfen, ob zu löschendes Verzeichnis auch existiert
		 * und ob dieses Verzeichnis auch leer ist, nur dann löschen
		 */
	
		$filepath = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $_REQUEST['path'] . $_REQUEST['dirname'];
		if(is_dir($filepath)){
			$handle = opendir($filepath);
			$cnt = 0;
			while($r = readdir($handle)){
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
		 * Pfad prüfen, ob Verzeichnis bereits existiert,
		 * andernfalls anlegen
		 */
	
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
		 * Pfad prüfen, ob Datei wirklich existiert, und nur dann
		 * auch löschen (evtl. TODO: Sicherheitsabfrage)
		 */
	
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
	
	} elseif($_REQUEST['action'] == 'doLogin'){
	
		/**
		 * Eingaben prüfen + wenn korrekt, Benutzer anmelden
		 */
	
		if(!empty($_POST['username']) && !empty($_POST['password'])){
			$testusername = "test";
			$testpassword = md5("test");
			if($_POST['username'] == $testusername && md5($_POST['password']) == $testpassword){
				$_SESSION['login']['type'] = "user";
				$_SESSION['login']['username'] = $_POST['username'];
				$_SESSION['login']['gruppe'] = "root";
				$message['ok'] = "Sie wurden erfolgreich eingeloggt!";
			} else {
				$message['error'] = "Benutzerdaten sind ungültig!";
				$_GET['action'] = "Login";
				$_POST['action'] = "Login";
			}
		} else {
			$message['error'] = "Geben Sie Benutzernamen und Passwort an!";
			$_GET['action'] = "Login";
			$_POST['action'] = "Login";
		}
		
	} elseif($_REQUEST['action'] == 'Logout'){
	
		/**
		 * Benutzer abmelden
		 */
	
		unset($_SESSION['login']);
		$message['ok'] = "Sie wurden erfolgreich abgemeldet!";
		
	}
	
	