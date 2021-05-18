function effects(){	

		var $window = $(window),
		$document = $(document),
		scrollTop = $window.scrollTop(),
                windowHeight = $window.height();
        //heightAnimated = windowHeight * .62;


        	if(scrollTop > (windowHeight-3)){

        		$("#cssMenL").html(".menu-logo { position: fixed; top: 0px; z-index: 99; }");
                        //$(".menu-logo").css({ "position": "fixed","top": "0px","z-index": "99" });
                        $(".contact-right").css({"position" : "fixed"});
                        $(".main_menu2").fadeIn("slow");
                        

        	}else{ 
        		$("#cssMenL").html("");
                        //$(".menu-logo").css({"position": "absolute", "top": "auto"});
                        $(".main_menu2").fadeOut(100);
                        $(".contact-right").css({"position" : "absolute"});
        	}

}

$(function() {
                $('.main-nav li a').bind('click', function(event) {
                        var $anchor = $(this);
                        var nav = $($anchor.attr('href'));
                        if (nav.length) {
                        $('html, body').stop().animate({                                
                                scrollTop: $($anchor.attr('href')).offset().top                         
                        }, 2500, 'easeInOutExpo');
                        
                        event.preventDefault();
                        }
                });
                $('a.totop,a#btn-scroll,a.btn-scroll,.carousel-inner .item a.btn').bind('click', function(event) {
                        var $anchor = $(this);
                        $('html, body').stop().animate({
                                scrollTop: $($anchor.attr('href')).offset().top
                        }, 1500, 'easeInOutExpo');
                        event.preventDefault();
                });
        });


