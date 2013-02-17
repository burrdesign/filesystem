<?php 

	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 17.2.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Headerausgabe für alle angemeldeten User
	 */
	 
	$root = getRoot();
	$sep = getRootSep();
	$reqpath = $_REQUEST['path'];
	
	echo "
		<div class='header_info'>
			Angemeldet als <span class='username'>".$_SESSION['login']['username']." (".$_SESSION['login']['gruppe'].")</span>
		</div>
		<div class='header_action'>";
		
		if($_SESSION['login']['gruppe'] == "root"){
			echo "
			<a class='button button_usermanagement' href='{$root}{$reqpath}{$sep}action=User'><span class='icon-user'></span> Benutzerverwaltung</a>
			";
		}
		
		echo "
			<a class='button button_login' href='{$root}{$reqpath}{$sep}action=Logout'><span class='icon-unlock-fill'></span> abmelden</a>
		</div>
		";