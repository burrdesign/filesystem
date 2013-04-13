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
		LEFT JOIN dateityp ON (Dateityp_Id = Datei_Dateityp_ID)
		LEFT JOIN autor ON (Autor_ID = Datei_Autor_ID)
		LEFT JOIN benutzergruppen ON (Gruppen_ID = Autor_Gruppen_ID)
		WHERE Datei_Speicherort = '{{path}}'
		LIMIT 1");
	$sql->bindParam("{{path}}", $filepath);
	$file = $sql->result();
	
	echo "<div class='innerbox'>";
	
	echo "<form name='saveFile' action='{$root}{$reqpath}' method='post' enctype='multipart/form-data'>
		<input type='hidden' name='action' value='saveFile'>
		<input type='hidden' name='Datei_ID' value='{$file['Datei_ID']}'>
		<table class='form form_newdir'>";
	
	if($_SESSION['login']['type'] == "user"){
		//Typ für Rechteverwaltung ermitteln
		$typ = "";
		if($file['Autor_ID'] == $_SESSION['login']['Autor_ID']){
			$typ = "User";
		} elseif($file['Autor_Gruppen_ID'] == $_SESSION['login']['Autor_Gruppen_ID']){
			$typ = "Gruppe";
		} else {
			$typ = "Rest";
		}
		
		//echo "<pre>{$file['Autor_ID']} == {$_SESSION['login']['Autor_ID']} :: typ={$typ}</pre>";
		
		$sql->setQuery("
			SELECT * FROM rechtetabelle
			WHERE Rechte_Datei_Id = {{fileID}} AND Rechte_Typ = '{{typ}}'
			LIMIT 1");
		$sql->bindParam("{{fileID}}", $file['Datei_ID'], "int");
		$sql->bindParam("{{typ}}", $typ);
		$rechte = $sql->result();
		
		if($typ == "User"){
			$rechte['Rechte_Schreiben'] = 1;
			$rechte['Rechte_Lesen'] = 1;
			$rechte['Rechte_Ausfuehren'] = 1;
		} elseif($_SESSION['login']['Autor_Gruppen_ID'] == 1){
			$rechte['Rechte_Lesen'] = 1;
			$rechte['Rechte_Ausfuehren'] = 1;
		}
		
		if($rechte['Rechte_Lesen'] != 1){
			echo "<tr><td><i>Sie haben nicht die notwendigen Rechte um diese Datei lesen zu d&uuml;rfen!</i></td></tr>";
		} else {
			if(!$file['Autor_ID']){
				$file['Autor_Vorname'] = "unkebannt";
				$file['Gruppen_Bezeichnung'] = "k.A.";
			}
		
			echo "<tr>
					<td class='label'>Dateityp:</td>
					<td>{$file['Dateityp_Bezeichnung']}</td>
				</tr>
				<tr>
					<td class='label'>Dateigr&ouml;&szlig;e:</td>
					<td>{$file['Datei_Groesse']} byte</td>
				</tr>
				<tr>
					<td class='label'>Autor:</td>
					<td>{$file['Autor_Vorname']} {$file['Autor_Name']} ({$file['Gruppen_Bezeichnung']})</td>
				</tr>
				<tr><td colspan='2' style='height:10px;'></td></tr>";
		
			//Rechtecheckboxen ausgeben
			$disabled = "";
			if($typ != "User"){
				$disabled = "disabled='disabled'";
			}
			if($typ == "User"){
				echo "<tr>
					<td class='label'>Eigene Rechte:</td>
					<td>
						<input type='hidden' name='Rechte_Datei_Id' value='{$file['Datei_ID']}'>
						<input type='hidden' name='Rechte_Typ' value='User'>
						<input type='checkbox' name='Rechte_Schreiben' value='1' checked='checked' disabled='disabled'> schreiben
						<input type='checkbox' name='Rechte_Lesen' value='1' checked='checked' disabled='disabled'> lesen
						<input type='checkbox' name='Rechte_Ausfuehren' value='1' checked='checked' disabled='disabled'> ausf&uuml;hren
					</td>
					</tr>";
					
					$sql->setQuery("
						SELECT * FROM rechtetabelle
						WHERE Rechte_Datei_Id = {{fileID}} AND Rechte_Typ = 'Gruppe'
						LIMIT 1");
					$sql->bindParam("{{fileID}}", $file['Datei_ID'], "int");
					$rechte_gruppe = $sql->result();
					
					$checked_schreiben = "";
					$checked_lesen = "";
					$checked_ausfuehren = "";
					if($rechte_gruppe['Rechte_Schreiben'] == 1) $checked_schreiben = "checked='checked'";
					if($rechte_gruppe['Rechte_Lesen'] == 1) $checked_lesen = "checked='checked'";
					if($rechte_gruppe['Rechte_Ausfuehren'] == 1) $checked_ausfuehren = "checked='checked'";
					echo "<tr>
						<td class='label'>Rechte (Gruppe):</td>
						<td>
							<input type='hidden' name='Gruppe_Rechte_Schreiben' value='0'>
							<input type='hidden' name='Gruppe_Rechte_Lesen' value='0'>
							<input type='hidden' name='Gruppe_Rechte_Ausfuehren' value='0'>
							<input type='checkbox' name='Gruppe_Rechte_Schreiben' value='1' {$checked_schreiben} {$disabled}> schreiben
							<input type='checkbox' name='Gruppe_Rechte_Lesen' value='1' {$checked_lesen} {$disabled}> lesen
							<input type='checkbox' name='Gruppe_Rechte_Ausfuehren' value='1' {$checked_ausfuehren} {$disabled}> ausf&uuml;hren
						</td>
						</tr>";
						
					$sql->setQuery("
						SELECT * FROM rechtetabelle
						WHERE Rechte_Datei_Id = {{fileID}} AND Rechte_Typ = 'Rest'
						LIMIT 1");
					$sql->bindParam("{{fileID}}", $file['Datei_ID'], "int");
					$rechte_rest = $sql->result();
						
					$checked_schreiben = "";
					$checked_lesen = "";
					$checked_ausfuehren = "";
					if($rechte_rest['Rechte_Schreiben'] == 1) $checked_schreiben = "checked='checked'";
					if($rechte_rest['Rechte_Lesen'] == 1) $checked_lesen = "checked='checked'";
					if($rechte_rest['Rechte_Ausfuehren'] == 1) $checked_ausfuehren = "checked='checked'";
					echo "<tr>
						<td class='label'>Rechte (Rest):</td>
						<td>
							<input type='hidden' name='Rest_Rechte_Schreiben' value='0'>
							<input type='hidden' name='Rest_Rechte_Lesen' value='0'>
							<input type='hidden' name='Rest_Rechte_Ausfuehren' value='0'>
							<input type='checkbox' name='Rest_Rechte_Schreiben' value='1' {$checked_schreiben} {$disabled}> schreiben
							<input type='checkbox' name='Rest_Rechte_Lesen' value='1' {$checked_lesen} {$disabled}> lesen
							<input type='checkbox' name='Rest_Rechte_Ausfuehren' value='1' {$checked_ausfuehren} {$disabled}> ausf&uuml;hren
						</td>
						</tr>";
			} else {
				$checked_schreiben = "";
				$checked_lesen = "";
				$checked_ausfuehren = "";
				if($rechte['Rechte_Schreiben'] == 1) $checked_schreiben = "checked='checked'";
				if($rechte['Rechte_Lesen'] == 1) $checked_lesen = "checked='checked'";
				if($rechte['Rechte_Ausfuehren'] == 1) $checked_ausfuehren = "checked='checked'";
				echo "<tr>
					<td class='label'>Rechte:</td>
					<td>
						<input type='checkbox' name='X_Rechte_Schreiben' value='1' {$checked_schreiben} {$disabled}> schreiben
						<input type='checkbox' name='X_Rechte_Lesen' value='1' {$checked_lesen} {$disabled}> lesen
						<input type='checkbox' name='X_Rechte_Ausfuehren' value='1' {$checked_ausfuehren} {$disabled}> ausf&uuml;hren
					</td>
					</tr>
					";
			}
			
			if($rechte['Rechte_Schreiben'] == 1){
				echo "<tr><td colspan='2' style='height:10px;'></td></tr>";
				echo "<tr>
					<td class='label'>Ersetzen:</td>
					<td><input type='file' name='upload'></td>
					</tr>";
			
				echo "<tr><td colspan='2' style='height:10px;'></td></tr>";
				echo "<tr><td colspan='2'><input type='submit' class='submit' value='&Auml;nderungen speichern'></td></tr>";
			}
		}
	} else {
		echo "<tr><td><i>Sie m&uuml;ssen angemeldet sein, um Details sehen zu k&ouml;nnen!</i></td></tr>";
	}
	
	echo "</table></form>";
	
	echo "</div>";

