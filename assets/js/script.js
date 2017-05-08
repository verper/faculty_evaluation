(function($){
	$(document).ready(function(){
		$('.nospace').keypress(function(e){
			if (e.charCode === 32) {
		    	e.preventDefault();
		  	}
		});
	});
})(jQuery);



function defer_init() {
	var imgDefer = document.getElementsByClassName('lazy-img');
	for (var i=0; i<imgDefer.length; i++) {
		if(imgDefer[i].getAttribute('data-src')) {
			imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
		} 
	} 
}
window.onload = defer_init;
