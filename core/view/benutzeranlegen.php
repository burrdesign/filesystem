<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 12.2.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe des Formulars zum anlegen eines neuen Verzeichnisses
	 */

	$root = getRoot();
	$sep = getRootSep();

	$reqpath = $_REQUEST['path'];
	$filepath = $_SERVER['DOCUMENT_ROOT']."files/".$reqpath;
	
	$reqname = $_REQUEST['dirname'];
	
	echo "<div class='innerbox'>";
	
	echo "
		<p>Legen Sie hier einen neuen Benutzer an.</p>
		";
		
	echo "
		<form name='newUser' action='{$root}{$reqpath}' method='post'>
			<input type='hidden' name='action' value='createUser'>
			<table class='form form_newdir'>
				<tr>
					<td>Benutzername:</td>
					<td><input type='text' class='text' name='Autor_Username' value='{$_REQUEST['Autor_Username']}'></td>
				</tr>
				<tr>
					<td>Passwort:</td>
					<td><input type='text' class='text' name='Autor_Passwort' value='{$_REQUEST['Autor_Passwort']}'></td>
				</tr>
				<tr>
					<td>Gruppe:</td>
					<td><select name='Autor_Gruppen_ID'>";
					
	$sql = new SqlManager();
	$sql->setQuery("
		SELECT * FROM benutzergruppen
		");
	$gruppenquery = $sql->execute();
	while($gruppe = mysql_fetch_array($gruppenquery)){
		$selected = "";
		if($_REQUEST['Autor_Gruppen_ID'] == $gruppe['Gruppen_ID']){
			$selected = "selected='selected'";
		}
		echo "<option value='{$gruppe['Gruppen_ID']}' {$selected}>{$gruppe['Gruppen_Bezeichnung']}</option>";
	}
	
	echo "
					</select></td>
				</tr>
				<tr>
					<td>Vorname:</td>
					<td><input type='text' class='text' name='Autor_Vorname' value='{$_REQUEST['Autor_Vorname']}'></td>
				</tr>
				<tr>
					<td>Nachname:</td>
					<td><input type='text' class='text' name='Autor_Name' value='{$_REQUEST['Autor_Name']}'></td>
				</tr>
				<tr>
					<td colspan='2'><input type='submit' class='submit' value='Benutzer anlegen'></td>
				</tr>
			</table>
		</form>
		";
	
	echo "</div>";