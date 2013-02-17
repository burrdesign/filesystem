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
		<p>Legen Sie hier ein neues Verzeichnis an. Geben Sie dazu den Namen des neuen Verzeichnisses an. Dieser muss eindeutig sein.</p>
		";
		
	echo "
		<form name='newDir' action='{$root}{$reqpath}' method='post'>
			<input type='hidden' name='action' value='createDir'>
			<table class='form form_newdir'>
				<tr>
					<td><input type='text' class='text' name='dirname' value='{$reqname}'></td>
					<td><input type='submit' class='submit' value='Verzeichnis anlegen'></td>
				</tr>
			</table>
		</form>
		";
	
	echo "</div>";