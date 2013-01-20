<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe der Actionbuttons im Slider
	 **/
	 
	$_TYPE = getActionType($_POST, $_GET);
	
	echo "<div class='slider_actions'>";

	if($_TYPE == "DIR"){
		echo "
			<a class='button_newdir'>Neues Verzeichnis</a>
			<a class='button_newfile'>Neue Datei</a>
			";
	}
	
	echo "</div>";
	
?>