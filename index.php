<?php 
	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Das ist die Hauptdatei der Medienverwaltung. Alle Anfragen laufen über diese index.php!
	 * Da diese Anforderung nur einen kleinen Umfang hat, macht es keinen Sinn hierfür ein
	 * umfangreiches MVC-Framework aufzubauen. Die Grundseite ist immer dieselbe, nur die Kopfzeile
	 * und der zentrale Inhalt (Slider) ändern sich je nach angefragtem Inhalt.
	 * Die Anfragen werden über folgende Parameter gesteuert:
	 *
	 * @Conroller-Parameter:
	 *		show	= Direktes Adressieren eine bestimmten Maske
	 *		path	= Der anzuzeigende Verzeichnis- oder Dateipfad
	 *		s		= Suchbegriff(e)
	 *		action	= auszuführende Action (z.B. Login, etc.)
	 *
	 * Diese Parameter könne als GET oder POST übergeben werden. An den beiden Stellen, die sich je
	 * nach Anfrage ändern wird der Inhalt über modulare Controller gesteuert! Dadurch wird das
	 * MVC-Prinzip auf minimalistischer Weise simuliert.
	 **/
	session_start(); 
	
	/**
	 * Allgemeine Variablen- und Funktionsbibliotheken laden
	 **/
	include($_SERVER['DOCUMENT_ROOT']."core/lib.php");
	
	/**
	 * Controller für die Actionphase (z.B. für den Dateiupload etc.)
	 **/
	include($_SERVER['DOCUMENT_ROOT']."core/controller/actions.php");
?>

<!doctype html>
<html>
<head>
	<title>Filesystem Alpha 0.1</title>
	
	<!-- jQuery-Framework + eigene Javascripte einbinden -->
	<script type="text/javascript" src="/javascripts/jquery.js"></script>
	<script type="text/javascript" src="/javascripts/main.js"></script>
	
	<!-- Stylesheets einbinden -->
	<link rel="stylesheet" type="text/css" href="/styles/main.css">
	
	<!-- Iconfont -->
	<link rel="stylesheet" href="/images/icons/iconfont/style.css">
	<!--[if lte IE 7]><script type="text/javascript" src="/images/icons/iconfont/lte-ie7.js"></script><![endif]-->
</head>

<body>

<div id="wrap_all">

	<!-- HEADER -->
	<div id="wrap_header">
		<div id="wrap_inner_header" class="wrapped_content">
			<?php
				/**
				 * Controller für den Header-Content
				 **/
				include($_SERVER['DOCUMENT_ROOT']."core/controller/header.php");
			?>
		</div>
	</div>
	
	<!-- HAUPTCONTENT -->
	<div id="wrap_content">
		<div id="wrap_inner_content" class="wrapped_content">
			<div class="intro">
				<h1>Dies ist das Test-Filesystem</h1>
				<p>Hier steht vielleicht irgendein einleitender Text oder so, der die Funktionsweise des Filesystems n&auml;her erl&auml;utert. Und dieser Text hier ist jetzt nur ein F&uuml;lltext, um das Design zu simulieren.</p>
			</div>
			
			<div class="searchbox">
				<form name="filesearch" action="" method="post">
					<input type="text" class="text" name="s" value="<?php echo $_REQUEST['s']; ?>">
					<input type="submit" class="search_submit icon-magnifying-glass" value="suchen">
				</form>
			</div>
			
			<div id="slider">
				<div id="wrap_inner_slider">
					<?php
						/**
						 * Controller für den Hauptcontent (Slider)
						 **/
						include($_SERVER['DOCUMENT_ROOT']."core/controller/slider.php");
					?>
				</div>
			</div>
		</div>
	</div>
	
	<!-- FOOTER -->
	<div id="wrap_footer">
	</div>

</div>

</body>
</html>