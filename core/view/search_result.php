<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Ausgabe des Suchergbnisses in der Slider-Hauptbox
	 */
	
	$root = getRoot();
	
	$keywords = explode(" ", $_REQUEST['s']);

	$query = "SELECT * FROM datei WHERE 1=1";
	$cnt = 0;
	foreach($keywords as $keyword){
		$cnt++;
		$query .= " AND (Datei_Bezeichnung LIKE '%{{keyword{$cnt}}}%')";
	}
	
	$sql = new SqlManager();
	$sql->setQuery($query);
	$cnt = 0;
	foreach($keywords as $keyword){
		$cnt++;
		$sql->bindParam("{{keyword{$cnt}}}", $keyword);
	}
	
	$result = $sql->execute();
	
	echo "<div class='filenavigation'>";
	echo "<div class='filetree'>";
	
	//Ergebnis-Tabelle ausgeben
	echo "<table class='file_list' cellpadding=0 cellspacing=0>";
	
	if(mysql_num_rows($result) <= 0){
	
		echo "<tr><td><i>Keine Dateien gefunden!</i></td></tr>";
		
	} else {
	
		$printedfirst = false;
		while($row = mysql_fetch_array($result)){
			/*echo "<pre>";
			print_r($row);
			echo "</pre>";*/
			
			if(!is_file($row['Datei_Speicherort'])){
				continue;
			}
			
			$class = "file";
			if(!$printedfirst){
				$class = "first ".$class;
				$printedfirst = true;
			}
			
			$printfile = str_replace($_SERVER['DOCUMENT_ROOT']."/files/", "", $row['Datei_Speicherort']);
			
			//letztes Änderungsdatum
			$lastchanged = date('D, j M Y H:i:s', filemtime($row['Datei_Speicherort']));
			
			//Dateigröße in Kilobyte (aufgerundet) ermitteln
			$filesize = filesize($row['Datei_Speicherort']);
			$filesize = $filesize / 1024;
			$filesize = ceil($filesize);
			$filesize_einheit = "kB";
			
			//ausgeben
			echo "
				<tr class='{$class} file'>
					<td class='icon'><span class='icon-document-alt-stroke'></span></td>
					<td class='name'><a href='{$root}{$printfile}'>{$row['Datei_Bezeichnung']}</a></td>
					<td class='type'>Datei</td>
					<td class='size'>{$filesize}{$filesize_einheit}</td>
					<td class='lastchanged'>{$lastchanged}</td>
				</tr>";
		}
		
	}
	
	echo "</table>";										

	echo "</div>";
	echo "</div>";