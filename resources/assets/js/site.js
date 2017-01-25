/**
 * JavaScripts for the Site
 *
 * @project ADR_DGDA
 * @author  Mayeenul Islam
 * @since   1.0.0
 */

jQuery(document).ready(function($){

	/* ----------------------------------------------------------- */
	/*  00. Affix TopBar
	/*      using: Bootstrap Affix
	/* ----------------------------------------------------------- */
	$('#top-bar').affix({
		offset: 15
	});


	/* ----------------------------------------------------------- */
	/*  01. iNewsTicker
	/*      using: iNewsTicker
	/* ----------------------------------------------------------- */
	var newsticker_holder = $('#feed-news');

	if( newsticker_holder.length > 0 ) {
		newsticker_holder.inewsticker({
		        speed       : 3000,
		        effect      : 'fade', //fade, typing, slide
		        dir         : 'ltr',
		        delay_after : 1000      
		});
	}


	/* ----------------------------------------------------------- */
    /*  03. MatchHeight
    /* 		using: matchHeight
    /* ----------------------------------------------------------- */
	var front_box 		= $('.front-box'),
		medicine_card 	= $('.medicine-card'),
		company_card 	= $('.company-card'),
		news_card 		= $('.news-card');

	if( front_box.length > 0 ) {
		front_box.matchHeight();
	}

	if( medicine_card.length > 0 ) {
		medicine_card.matchHeight();
	}

	if( company_card.length > 0 ) {
		company_card.matchHeight();
	}

	if( news_card.length > 0 ) {
		news_card.matchHeight();
	}
    
});
