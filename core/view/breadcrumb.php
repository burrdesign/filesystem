<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe des aktuellen Verzeichnis- bzw. Dateipfades (Breadcrumb) im Slider-Titel
	 */
	 
	$_TYPE = getActionType($_POST, $_GET);
	
	$root = getRoot();
	$reqpath = $_REQUEST['path'];
	
	echo "<h3 class='breadcrumb'>";
	
	if($_TYPE == "DIR" || $_TYPE == "FILE" || $_TYPE == "NEWDIR" || $_TYPE == "NEWFILE"){
	
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
		$icon = "icon-book-alt2";
		if($_TYPE == "NEWFILE"){
			$icon = "icon-upload";
		}
		echo "<div class='path_icon_box'><span class='icon {$icon}'></span></div>";
		echo "<span class='path_icon_box_pfeil'></span>";

	} elseif($_TYPE == "SEARCH"){
	
		$keywords = $_REQUEST['s'];
		echo "<span class='first'>Suchergebnis f&uuml;r</span> <span class='keywords'>{$keywords}</span>";
		
		//Breadcrumb-Icon ausgeben
		echo "<div class='path_icon_box'><span class='icon icon-magnifying-glass'></span></div>";
		echo "<span class='path_icon_box_pfeil'></span>";
	
	} elseif($_TYPE == "LOGIN"){
	
		$keywords = $_REQUEST['s'];
		echo "<span class='first'>Melden Sie sich an</span>";
		
		//Breadcrumb-Icon ausgeben
		echo "<div class='path_icon_box'><span class='icon icon-lock-fill'></span></div>";
		echo "<span class='path_icon_box_pfeil'></span>";
	
	} elseif($_TYPE == "USER"){
	
		$keywords = $_REQUEST['s'];
		echo "<span class='first'>Benutzerverwaltung</span>";
		
		//Breadcrumb-Icon ausgeben
		echo "<div class='path_icon_box'><span class='icon icon-user'></span></div>";
		echo "<span class='path_icon_box_pfeil'></span>";
	
	}
	
	echo "</h3>";
