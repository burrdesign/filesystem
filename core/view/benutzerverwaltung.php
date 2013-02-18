<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe der aktuell existierenden Benutzer
	 * für die Benutzerverwaltung
	 */

	$root = getRoot();
	$sep = getRootSep();

	$reqpath = $_REQUEST['path'];
	
	/**
	 * Benutzer aus Datenbank laden
	 */
	
	$sql = new SqlManager();
	$sql->setQuery("
		SELECT * FROM autor
		inner join benutzergruppen on Autor_Gruppen_ID = Gruppen_ID
		");
	$users = $sql->execute();

?>
	
<div class='usernavigation'>
<div class='userlist'>
	
<table class='user_list' cellpadding=0 cellspacing=0>

	<?php
	
		/**
		 * Liste aller Benutzer ausgeben
		 */
	
		while($user = mysql_fetch_array($users)){
			$class="first";
			echo "
				<tr class='{$class} root'>
					<td class='login'><a href='".$root.$reqpath.$sep."action=UserDetail&userid={$user[Autor_ID]}'>{$user['Autor_Username']}</a></td>
					<td class='name'>{$user['Autor_Vorname']}</td>
					<td class='nachname'>{$user['Autor_Name']}</td>
					<td class='gruppe'>{$user['Gruppen_Bezeichnung']}</td>
					<td class='deleteUser'><a href='".$root.$reqpath.$sep."action=deleteUser&userid={$user[Autor_ID]}'><span class='icon-x'></span></a></td>
				</tr>";
			$class="";
				
		}
		
	?>

	

</table>										
	
	
</div>
</div>