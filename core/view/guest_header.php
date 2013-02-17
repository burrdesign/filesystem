<?php 

	/**
	 * @Autor: Julia Betzer, Julian Burr
	 * @Datum: 20.1.2013
	 * @Version: Alpha 0.1
	 *
	 * @Anmerkungen:
	 * Headerausgabe für alle Gäste (nicht angemeldete User)
	 */
	 
	$root = getRoot();
	$sep = getRootSep();
	$reqpath = $_REQUEST['path'];
	
	echo "
		<div class='header_action'>
			<a class='button button_login' href='{$root}{$reqpath}{$sep}action=Login'><span class='icon-lock-fill'></span> anmelden</a>
		</div>
		";