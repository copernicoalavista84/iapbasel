/*global $:false */
(function($) {
	"use strict";

	$.extend($.easing, window.easing);

	$(window).load(function() {
		$("#status").fadeOut();
		$("#preloader").delay(350).fadeOut("slow");

		var $container = $('.portfolio');
		var $filter = $('#filter');
		// Initialize isotope
		$container.isotope({
			filter: '*',
			layoutMode: 'fitRows',
			animationOptions: {
				duration: 750,
				easing: 'linear'
			}
		});
		// Filter items when filter link is clicked
		$filter.find('a').click(function() {
			var selector = $(this).attr('data-filter');
			$filter.find('a').removeClass('current');
			$(this).addClass('current');
			$container.isotope({
				filter: selector,
				animationOptions: {
					animationDuration: 750,
					easing: 'linear',
					queue: false,
				}
			});
			return false;
		});

	});

	$(window).resize(function() {
		$('#home').css({
			'height': ($(window).height()) + 'px'
		});
		if ($(window).width() >= 960) {
			if ($("ul#menu li").css('display') == 'none') $("ul#menu li").css('display', 'inline');
		} else {
			$("ul#menu li").css('display', 'none');
		}
	});

	$(document).ready(function() {

		$("html").niceScroll();

		$('#home').css({
			'height': ($(window).height()) + 'px'
		});

		$("#navigation").sticky({
			topSpacing: 0
		});

		$('.section:odd').addClass('alt');
		$('.work-entry:even').addClass('works-sec');
		$('.post-entry:even').addClass('blog-sec');

		$("ul#menu").click(function() {
			if ($("ul#menu li").css('display') != 'inline') {
				if ($("ul#menu").hasClass('showmenu')) {
					$("ul#menu").removeClass('showmenu');
					$("ul#menu li").css('display', 'none');
				} else {
					$("ul#menu").addClass('showmenu');
					$("ul#menu li").css('display', 'block');
				}
			}
		});

		$('ul li a').click(function() {
			var item = $(this).parent();
			$('ul li').removeClass('current');
			item.addClass("current")
		});

		$('#cbp-fwslider').cbpFWSlider();

		$(".scroll").click(function(event) {

			event.preventDefault();

			var $this = $(this);

			if ($this.hasClass('next-section')) {

				$('html, body').animate({
					scrollTop: $('#header').next().offset().top
				}, 1800);
			} else {
				var full_url = this.href,
					parts = full_url.split("#"),
					trgt = parts[1],
					target_offset = $("#" + trgt).offset(),
					target_top = target_offset.top;

				$('html, body').animate({
					scrollTop: target_top
				}, 1800);
			}
		});

		// Twitter
        var $twitter = $('#jstweets');
        if( $twitter.length > 0 ) {
            
            $.ajax({
                url: $twitter.data('url'),
                dataType: 'json',
                success: function(data){
                    $.each(data, function(i,item){
                        var ct = item.text,
                            mytime = item.created_at,
                            strtime = mytime.replace(/(\+\S+) (.*)/, '$2 $1'),
                            mydate = new Date(Date.parse(strtime)).toLocaleDateString(),
                            mytime = new Date(Date.parse(strtime)).toLocaleTimeString(),
                            twitterURL = "http://twitter.com/";
                        
                        ct = ct.replace(/http:\/\/\S+/g,  '<a href="$&" target="_blank">$&</a>');
                        ct = ct.replace(/\s(@)(\w+)/g,    ' @<a href="'+twitterURL+'$2">$2</a>');
                        ct = ct.replace(/\s(#)(\w+)/g,    ' #<a href="'+twitterURL+'search?q=%23$2" target="_blank">$2</a>');
                        $twitter.append('<div>'+ct + ' <small><i>(' + mydate + ' @ ' + mytime + ')</i></small></div>');
                    });
                    
                    $twitter.find('> div').quovolver();
                }
            });
        }

		$('.fancybox').fancybox();

		$('.fancybox-media').attr('rel', 'media-gallery').fancybox({
			openEffect: 'none',
			closeEffect: 'none',
			prevEffect: 'none',
			nextEffect: 'none',

			arrows: false,
			helpers: {
				media: {},
				buttons: {}
			}
		});

		try {
			var map;
			var $map = $('#map');

			$map.parents('.section').addClass('nopt');
			map = new GMaps({
				scrollwheel: false,
				el: '#map',
				lat: $map.data('lat'),
				lng: $map.data('long')
			});
			map.drawOverlay({
				lat: map.getCenter().lat(),
				lng: map.getCenter().lng(),
				layer: 'overlayLayer',
				content: '<div class="overlay"></div>',
				verticalAlign: 'bottom',
				horizontalAlign: 'center'
			});
		} catch (e) {

		}

		/* Parallax */
		$('.parallax').each(function(index, obj) {
			var $this = $(this),
				$bg = $this.find('.separator-bg');

			$this.removeClass('parallax');
			$bg.css('backgroundImage', 'url(' + $this.data('bg') + ')');
			$bg.parallax('50%', $this.data('speed'));

		});
	});

})(jQuery);