// Navigation JS and jQuery

$('document').ready(function(){ // begin doc ready
	
	$('.navButton').hover(function(){
		
		$(this).css("background-color", "blue");
		$(this).css("color", "white");
		$(this).css("border", "solid 3px white");
		
	}, function(){
			
		$(this).css("background-color", "gray");
		$(this).css("color", "black");
		$(this).css("border", "solid 3px black");	
		
	});
		
}); // end doc ready - don't delete!