<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe des aktuellen Verzeichnis- bzw. Dateipfades (Breadcrumb) im Slider-Titel
	 **/
	 
	$_TYPE = getActionType($_POST, $_GET);
	
	$root = getRoot();
	$reqpath = $_REQUEST['path'];
	
	echo "<h3 class='breadcrumb'>";
	
	if($reqpath == ""){
	
		//Leerer Pfad angegen, also wird Root-Verzeichnis ausgegeben
		echo "<span class='root'>.</span> / ";
		
	} else {
	
		//Link zum Root-Verzeichnis
		echo "<a href='{$root}'><span class='root'>.</span></a> / ";
		
		//Verzeichnis- bzw. Dateipfad anhand der Slashes aufteilen
		$pathdirs = explode("/",$reqpath);
		
		//... und mit entsprechender Verlinkung ausgeben
		$rekdir = "";
		foreach($pathdirs as $printdir){
			if(!$printdir) continue;
			
			if(is_file($_SERVER['DOCUMENT_ROOT']."files/{$rekpath}{$printdir}")){
				$rekpath = $rekpath.$printdir;
			} else {
				$rekpath = $rekpath.$printdir."/";
			}
			if($rekpath == $reqpath){
				if(is_file($_SERVER['DOCUMENT_ROOT']."files/{$rekpath}")){
					echo "<span class='path'>{$printdir}</span>";
				} else {
					echo "<span class='path'>{$printdir}</span> / ";
				}
			} else {
				echo "<a href='{$root}{$rekpath}' title='{$printdir}'><span class='path'>{$printdir}</span></a> / ";
			}
		}
	}
	
	//Breadcrumb-Icon ausgeben
	echo "<div class='path_icon_box'><span class='icon icon-book-alt2'></span> Pfad</div>";
	echo "<span class='path_icon_box_pfeil'></span>";
	
	echo "</h3>";

