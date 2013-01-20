<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe der Suchbegriffe im Slider-Titel
	 **/
	
	$keywords = $_REQUEST['s'];
	echo "<h3 class='breadcrumb'><span class='search_title_intro'>Suchergebnis f&uuml;r</span> <span class='keywords'>{$keywords}</span></h3>";
	
?>

