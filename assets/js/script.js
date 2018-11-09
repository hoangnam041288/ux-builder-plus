jQuery(document).ready(function ($) {
	var lactroi = $(".lactroi-on");
	if(lactroi.length){
		$(window).on('scroll', function () {
			var stuck = $("#header .stuck").height()+10;
			var prev = $(window).scrollTop()-(lactroi.prev().offset().top+lactroi.prev().height()-stuck);
			var star = lactroi.closest(".col").offset().top+lactroi.closest(".col").height();
			var ends = $(window).scrollTop()+( lactroi.find(".row").height() );
			var row = lactroi.find(".row");
			if ( prev <= 0 ) {
				row.css({'position':'relative','top':'0'});
			} else {
				row.css({'position':'fixed','width':lactroi.prev().width()});
				if( (ends+60)-star >= 0 ) {
					row.css({'top':star-(ends-stuck+60)+'px'});
				} else {
					row.css({'top':stuck+'px'});
				}
			}
		});
	}
});