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

?>
	
<div class='usernavigation'>
<div class='userlist'>
	
<table class='user_list' cellpadding=0 cellspacing=0>

	<tr class='first root'>
		<td class='login'><a href="<?php echo $root.$reqpath.$sep."action=UserDetail&userid=x"; ?>">test</a></td>
		<td class='name'>Max</td>
		<td class='nachname'>Mustermann</td>
		<td class='gruppe'>root</td>
		<td class='lastlogin'><?php echo date('D, j M Y H:i:s', time()); ?></td>
		<td class='deleteUser'><a href="<?php echo $root.$reqpath.$sep."action=deleteUser&userid=x"; ?>"><span class='icon-x'></span></a></td>
	</tr>

</table>										
	
	
</div>
</div>