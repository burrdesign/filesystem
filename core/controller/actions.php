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
	$sql = new SqlManager();
	 
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
			if(is_dir($filepath)){
				$message['ok'] = "Verzeichnis wurde erfolgreich angelegt!";
			} else {
				$message['error'] = "Verzeichnis konnte nicht angelegt werden!";
			}
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
			//Datei hochladen
			move_uploaded_file($_FILES['upload']['tmp_name'],$filepath);
			
			if(is_file($filepath)){
				//Datenbankeintrag vorbereiten
				$new = array();
				$new['Datei_Speicherort'] = $filepath;
				$new['Datei_Bezeichnung'] = $_FILES['upload']['name'];
				$new['Datei_Autor_ID'] = $_SESSION['login']['Autor_ID'];
				$new['Datei_Groesse'] = filesize($filepath);
				
				//Dateityp ermitteln und gucken, ob der Typ bereits existiert
				$filetype = mime_content_type($filepath);
				$sql->setQuery("
					SELECT Dateityp_Id FROM dateityp
					WHERE Dateityp_Bezeichnung = '{{typ}}'
					LIMIT 1");
				$sql->bindParam("{{typ}}", $filetype);
				$type = $sql->result();
				
				//wenn Typ vorhanden ist, Id verwenden, sonst neu anlegen
				if($type['Dateityp_Id']){
					$new['Datei_Dateityp_ID'] = $type['Dateityp_Id'];
				} else {
					$newtype = array();
					$newtype['Dateityp_Bezeichnung'] = $filetype;
					$sql->insert("dateityp", $newtype);
					$new['Datei_Dateityp_ID'] = $sql->getLastInsertID();
				}
				
				//Datei in DB schreiben
				$sql->insert("datei", $new);
				$new['Datei_ID'] = $sql->getLastInsertID();
				
				//Dateirechte
				$insert = array(
					"Rechte_Datei_Id" => $new['Datei_ID'],
					"Rechte_Typ" => "User",
					"Rechte_Schreiben" => 1,
					"Rechte_Lesen" => 1,
					"Rechte_Ausfuehren" => 1);
				$sql->insert("rechtetabelle", $insert);
				
				$insert = array(
					"Rechte_Datei_Id" => $new['Datei_ID'],
					"Rechte_Typ" => "Gruppe",
					"Rechte_Schreiben" => 1,
					"Rechte_Lesen" => 1,
					"Rechte_Ausfuehren" => 1);
				$sql->insert("rechtetabelle", $insert);
				
				$insert = array(
					"Rechte_Datei_Id" => $new['Datei_ID'],
					"Rechte_Typ" => "Rest",
					"Rechte_Schreiben" => 0,
					"Rechte_Lesen" => 1,
					"Rechte_Ausfuehren" => 0);
				$sql->insert("rechtetabelle", $insert);
				
				//Action löschen + Message definieren
				unset($_GET['action']);
				unset($_POST['action']);
				$message['ok'] = "Datei wurde erfolgreich hochgeladen!";
			} else {
				//Fehler beim Upload
				unset($_GET['action']);
				unset($_POST['action']);
				$message['error'] = "Es ist ein Fehler beim Upload aufgetreten!";
			}
		}
	
	} elseif($_REQUEST['action'] == 'saveFile'){
	
		$filepath = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $_REQUEST['path'] . $_REQUEST['filename'];
		
		$upd = array();
		$upd = $_REQUEST;
		
		if($_FILES['upload']['tmp_name']){
			move_uploaded_file($_FILES['upload']['tmp_name'],$filepath);
			
			$upd['Datei_Groesse'] = filesize($filepath);
			
			//Dateityp ermitteln und gucken, ob der Typ bereits existiert
			$filetype = mime_content_type($filepath);
			$sql->setQuery("
				SELECT Dateityp_Id FROM dateityp
				WHERE Dateityp_Bezeichnung = '{{typ}}'
				LIMIT 1");
			$sql->bindParam("{{typ}}", $filetype);
			$type = $sql->result();
			
			//wenn Typ vorhanden ist, Id verwenden, sonst neu anlegen
			if($type['Dateityp_Id']){
				$upd['Datei_Dateityp_ID'] = $type['Dateityp_Id'];
			} else {
				$newtype = array();
				$newtype['Dateityp_Bezeichnung'] = $filetype;
				$sql->insert("dateityp", $newtype);
				$upd['Datei_Dateityp_ID'] = $sql->getLastInsertID();
			}
		}
		
		$sql->update("datei", $upd);
		
		//Rechte updaten bzw. falls nötig inserten
		$del = array();
		$del = $_REQUEST;
		if($del['Rechte_Typ'] == "User"){
			$sql->delete("rechtetabelle", $del);
			$sql->insert("rechtetabelle", $del);
			
			//Gruppenrechte
			$del['Rechte_Typ'] = "Gruppe";
			$del['Rechte_Schreiben'] = $del['Gruppe_Rechte_Schreiben'];
			$del['Rechte_Lesen'] = $del['Gruppe_Rechte_Lesen'];
			$del['Rechte_Ausfuehren'] = $del['Gruppe_Rechte_Ausfuehren'];
			$sql->delete("rechtetabelle", $del);
			$sql->insert("rechtetabelle", $del);
			
			//Resterechte
			$del['Rechte_Typ'] = "Rest";
			$del['Rechte_Schreiben'] = $del['Rest_Rechte_Schreiben'];
			$del['Rechte_Lesen'] = $del['Rest_Rechte_Lesen'];
			$del['Rechte_Ausfuehren'] = $del['Rest_Rechte_Ausfuehren'];
			$sql->delete("rechtetabelle", $del);
			$sql->insert("rechtetabelle", $del);
			
		} else {
			$sql->delete("rechtetabelle", $del);
			$sql->insert("rechtetabelle", $del);
		}
		
		$message['ok'] = "Datei wurde erfolgreich gespeichert!";
	
	} elseif($_REQUEST['action'] == 'deleteFile'){
	
		/**
		 * Pfad prüfen, ob Datei wirklich existiert, und nur dann
		 * auch löschen (evtl. TODO: Sicherheitsabfrage)
		 */
	
		$filepath = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $_REQUEST['path'] . $_REQUEST['filename'];
		$file = array();
		$sql->setQuery("
			SELECT Datei_ID FROM datei
			WHERE Datei_Speicherort = '{{Pfad}}'
			LIMIT 1");
		$sql->bindParam("{{Pfad}}", $filepath);
		$file = $sql->result();
		
		if(!is_file($filepath)){
			$message['error'] = "Datei konnte nicht gel&ouml;scht werden!";
			unset($_GET['action']);
			unset($_POST['action']);
			unset($_REQUEST['action']);
		} else {
			unlink($filepath);
			$sql->delete("datei", $file);
			unset($_GET['action']);
			unset($_POST['action']);
			unset($_REQUEST['action']);
			$message['ok'] = "Datei wurde erfolgreich gel&ouml;scht!";
		}
		
	} elseif($_REQUEST['action'] == 'saveUser'){
	
		/**
		 * Benutzerdaten speichern
		 */
		if($_REQUEST['Autor_Username'] == ""){
			$message['error'] = "Es muss ein Benutzername angegeben werden!";
		} else {
			$sql->setQuery("
				SELECT Autor_ID FROM autor
				WHERE Autor_Username = {{username}} AND Autor_ID != {{id}}");
			$sql->bindParam("{{username}}", $_REQUEST['Autor_Username']);
			$sql->bindParam("{{id}}", $_REQUEST['Autor_ID'], "int");
			$test = $sql->execute();
			
			if(mysql_num_rows($test) > 0){
				$message['error'] = "Benutzername ist bereits vergeben!";
			} else {
				//OK, Benutzer speichern
				if(!empty($_REQUEST['Autor_Passwort'])){
					$_REQUEST['Autor_Passwort'] = md5($_REQUEST['Autor_Passwort']);
				}
				$sql->update("autor", $_REQUEST);
				$message['ok'] = "&Auml;nderungen wurden erfolgreich gespeichert!";
			}
		}
		
		$_GET['action'] = "UserDetail";
		$_POST['action'] = "UserDetail";
		$_REQUEST['action'] = "UserDetail";
		
	} elseif($_REQUEST['action'] == 'deleteUser' && $_REQUEST['userid']){
	
		/**
		 * Benutzer löschen
		 */
		if($_REQUEST['userid'] == $_SESSION['login']['Autor_ID']){
			$message['error'] = "Bitte keinen Suizid begehen!";
			$_GET['action'] = "UserDetail";
			$_POST['action'] = "UserDetail";
			$_REQUEST['action'] = "UserDetail";
		} else {
			$delete = array();
			$delete['Autor_ID'] = $_REQUEST['userid'];
			$sql->delete("autor", $delete);
			$message['ok'] = "Benutzer wurde erfolgreich gel&ouml;scht!";
			$_GET['action'] = "User";
			$_POST['action'] = "User";
			$_REQUEST['action'] = "User";
		}
	
	} elseif($_REQUEST['action'] == 'createUser'){
	
		/**
		 * Neuen Benutzer anlegen
		 */
		if(empty($_REQUEST['Autor_Username']) || empty($_REQUEST['Autor_Passwort'])){
			//Nötige Daten wurden nicht angegeben
			$message['error'] = "Bitte geben Sie alle notwendigen Daten an!";
			$_GET['action'] = "NewUser";
			$_POST['action'] = "NewUser";
			$_REQUEST['action'] = "NewUser";
		} else {
		
			//Prüfen, ob Benutzername schon existiert
			$sql->setQuery("
				SELECT Autor_ID FROM autor
				WHERE Autor_Username = '{{username}}'");
			$sql->bindParam("{{username}}", $_REQUEST['Autor_Username']);
			$test = $sql->execute();
			
			if(mysql_num_rows($test) > 0){#
			
				$message['error'] = "Benutzername wird bereits verwendet!";
				$_GET['action'] = "newUser";
				$_POST['action'] = "newUser";
				$_REQUEST['action'] = "newUser";
				
			} else {
			
				$_REQUEST['Autor_Passwort'] = md5($_REQUEST['Autor_Passwort']);
				$sql->insert("autor", $_REQUEST);
				
				$message['ok'] = "Benutzer wurde erfolgreich angelegt!";
				
				$_GET['action'] = "User";
				$_POST['action'] = "User";
				$_REQUEST['action'] = "User";
			
			}
		}
	
	} elseif($_REQUEST['action'] == 'doLogin'){
	
		/**
		 * Eingaben prüfen + wenn korrekt, Benutzer anmelden
		 */
	
		if(!empty($_POST['username']) && !empty($_POST['password'])){
			
			$sql = new SqlManager();
			$sql->setQuery("
				SELECT * FROM autor
				inner join benutzergruppen on Autor_Gruppen_ID = Gruppen_ID
				WHERE Autor_Username = '{{username}}' AND Autor_Passwort = '{{passwort}}'
				LIMIT 1
				");
			$sql->bindParam("{{username}}", $_POST['username']);
			$sql->bindParam("{{passwort}}", md5($_POST['password']));
			$user = $sql->result();
			
			if($user['Autor_ID']){
				$_SESSION['login'] = $user;
				$_SESSION['login']['type'] = "user";
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
	
	