<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe des aktuellen Verzeichnisinhalts anhand des Pfad-Parameters
	 **/

	$root = getRoot();

	$reqpath = $_REQUEST['path'];
	$filepath = $_SERVER['DOCUMENT_ROOT']."files/".$reqpath;
	
	$pathdirs = explode("/",$reqpath);
	$parentpath = str_replace($pathdirs[count($pathdirs)-2]."/","",$reqpath);
	
	echo "<div class='filenavigation'>";
	echo "<div class='filetree'>";
	
	//Verzeichnisbaum-Tabelle ausgeben
	echo "<table class='file_list' cellpadding=0 cellspacing=0>";
	
	//Hilfsarrays für die Dateien / Verzeichnisse
	$dirs = array();
	$files = array();
	
	//Verzeichnis auslesen und Dateien und Verzeichnisse in die Hilfsarrays schreiben
	$handle = opendir($filepath);
	while($file = readdir($handle)){
		//Systemverzeichnisse nicht speichern
		if($file == "." || $file == "..") continue;
		
		if(is_dir($filepath.$file)){
			$dirs[] = $file;
		} elseif(is_file($filepath.$file)){
			$files[] = $file;
		}
	}
	
	//Hilfsvariable, um dem ersten Tabellenelement eine entsprechende Klasse zuweisen zu können
	$printedfirst = false;
	
	if($reqpath != ""){
		//Link zum Elternverzeichnis (nicht im Root-Verzeichnis ausgeben)
		echo "
			<tr class='first root'>
				<td class='icon noicon'></td>
				<td class='name'><a href='{$root}{$parentpath}'>..</a></td>
				<td class='type'></td>
				<td class='size'></td>
				<td class='lastchanged'></td>
			</tr>";
		$printedfirst = true;
	}
	
	//zuerst alle Verzeichnisse ausgeben
	foreach($dirs as $printdir){
		$class = "dir";
		if(!$printedfirst){
			$class = "first ".$class;
			$printedfirst = true;
		}
		echo "
			<tr class='{$class}'>
				<td class='icon icon_dir'></td>
				<td class='name'><a href='{$root}{$reqpath}{$printdir}/'>{$printdir}</a></td>
				<td class='type'>Verzeichnis</td>
				<td class='size'></td>
				<td class='lastchanged'></td>
			</tr>";
	}

	//... dann alle Dateien inkl. der vorhandenen Informationen ausgeben
	foreach($files as $printfile){
		$class = "file";
		if(!$printedfirst){
			$class = "first ".$class;
			$printedfirst = true;
		}
		
		//letztes Änderungsdatum
		$lastchanged = date('D, j M Y H:i:s', filemtime($_SERVER['DOCUMENT_ROOT']."files/{$reqpath}{$printfile}"));
		
		//Dateigröße in Kilobyte (aufgerundet) ermitteln
		$filesize = filesize($_SERVER['DOCUMENT_ROOT']."files/{$reqpath}{$printfile}");
		$filesize = $filesize / 1024;
		$filesize = ceil($filesize);
		$filesize_einheit = "kB";
		
		//ausgeben
		echo "
			<tr class='{$class}'>
				<td class='icon icon_file'></td>
				<td class='name'><a href='{$root}{$reqpath}{$printfile}'>{$printfile}</a></td>
				<td class='type'>Datei</td>
				<td class='size'>{$filesize}{$filesize_einheit}</td>
				<td class='lastchanged'>{$lastchanged}</td>
			</tr>";
	}

	echo "</table>";										
	
	
	echo "</div>";
	echo "</div>";
	
?>