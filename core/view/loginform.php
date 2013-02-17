<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 16.2.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe des Login-Formulars
	 */

	$root = getRoot();
	$sep = getRootSep();

	$reqpath = $_REQUEST['path'];
	$filepath = $_SERVER['DOCUMENT_ROOT']."files/".$reqpath;
	
	$reqname = $_REQUEST['dirname'];
	
	echo "<div class='innerbox'>";
	
	echo "
		<p>Loggen Sie sich mit Ihrem Benutzernamen und Ihrem Passwort ein, um Dateien bearbeiten und verwalten zu k&ouml;nnen.</p>
		";
		
	echo "
		<form name='Login' action='{$root}{$reqpath}' method='post'>
		<table class='form login_form' cellpadding=0 cellspacing=0>
			<input type='hidden' name='action' value='doLogin'>
			<tr>
				<td class='label'>Benutzername:</td>
				<td><input type='text' class='text' name='username' value='".$_REQUEST['username']."'></td>
			</tr>
			<tr>
				<td class='label'>Passwort:</td>
				<td><input type='password' class='text' name='password'></td>
			</tr>
			<tr>
				<td colspan=2><input type='submit' class='submit' value='Login'></td>
			</tr>
		</table>
		</form>
		";
	
	echo "</div>";