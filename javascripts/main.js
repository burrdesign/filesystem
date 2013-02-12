/**
 * @Autor: Julia Betzer, Julian Burr
 * @Datum: 20.1.2013
 * @Version: Alpha 0.1
 *
 * @Anmerkungen:
 * Haupt-Skriptdatei, da es bei den wenigen Funktion nicht wirklich Sinn macht,
 * die Funktionen alle in separate Dateien zu packen.
 **/

$(document).ready(function(){

	//Lade-Overlay initialisieren
	if($("#overlay") == false){
		$("body").append("<div id='overlay'></div>");
	}
	$("#overlay").css("opacity",0.2).hide();
	
	$("#slider a").live("click",function(){
	
		//Ziel ermitteln
		var linkhref = $(this).attr("href");
	
		//Lade-Overlay einblenden + Body-Overflow aufheben (um Scrollbar zu vermeiden)
		$("#overlay").show();
		$("body").css("overflow-x","hidden");
		
		//Messages einklappen
		$("#wrap_header .message").slideUp("100");
		
		//Slider-Box nach links aus dem Bildschirm sliden
		$("#slider").animate({ "margin-left":"-" + $(window).width() + "px" },400,"",function(){
		
			//neue Seite per AJAX in die Box laden
			//$("#slider").load(linkhref);
			$("#slider").load(linkhref + " #wrap_inner_slider");
			$("#wrap_header").load(linkhref + " #wrap_inner_header");
			
			//URL in die URL-Leiste eintragen (HTML5!, hier sollte ggf. auch die History manipuliert werden!?)
			var stateObj = { foo: "bar" };
			if(typeof history.pushState != "undefined"){ 
				history.pushState(stateObj, "", linkhref);
			}
			
			//Box nach rechts neben den Bildschirm setzen
			$("#slider").css("margin-left",$(window).width() + "px");
			
			//Box an die Ursprungsposition sliden
			$("#slider").animate({ "margin-left":0 },400,"",function(){
				//Overlay wieder ausblenden + Overflow wieder aufheben
				$("#overlay").hide();
				$("body").css("overflow-x","auto");
				//Messages ausklappen
				$("#wrap_header .message").slideDown("100");
			});

		});
		
		//das eigentliche Click-Event des Links unterdrücken
		return false;
		
	});
	
});