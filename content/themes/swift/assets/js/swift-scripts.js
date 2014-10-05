/*
 * Delayed loading of gravatars
 */
jQuery(window).load(function() {
    jQuery('img[data-gravatar-hash]').each(function(){
	    var hash = jQuery(this).attr('data-gravatar-hash');
	    var img_url = 'http://www.gravatar.com/avatar/'+hash;
	    jQuery(this).attr('src',img_url);
	 });
});


/* Image width in the posts can be max 550px */
	jQuery(window).load(function() {
		jQuery('article .wp-caption img').each(function() {
			current_width 			= jQuery(this).width();
			current_resized_width 	= jQuery(this).attr('width');
			current_height 			= jQuery(this).height();
			content_width 			= jQuery('#content').width() - 40;
			

			aspect_ratio = current_width/current_height;
			if(current_width > content_width && current_resized_width>content_width) {
				jQuery(this).removeAttr('width');
				jQuery(this).removeAttr('height');
			
				new_height = content_width/aspect_ratio;
				jQuery(this).width(content_width+'px');
				jQuery(this).height(new_height);
				jQuery(this).addClass( 'resized aligncenter' )

			}
		});
	});
	
	/* Image width in the posts can be max 550px */
	jQuery(window).load(function() {
		jQuery('.wp-caption').each(function() {
			jQuery(this).removeAttr('width');
			current_width = jQuery(this).width();
			current_height = jQuery(this).height();
			content_width=jQuery('#content').width()-30-10;
			
			
			aspect_ratio = current_width/current_height;
			if(current_width > content_width+10) {
				new_height = (content_width+10)/aspect_ratio;
				jQuery(this).width(content_width+10+'px');
				jQuery(this).addClass( 'resized aligncenter' )

			}
		});
	});

	jQuery(window).load(function() {
		jQuery('article img').each(function() {
			current_width 			= jQuery(this).width();
			padding_border_width 	= jQuery(this).outerWidth() - current_width;
			current_resized_width 	= jQuery(this).attr('width');
			current_height 			= jQuery(this).height();
			content_width 			= jQuery('#content').width() - 20 - padding_border_width;
			
			aspect_ratio = current_width/current_height;
			if(current_width > content_width && current_resized_width>content_width) {
				jQuery(this).removeAttr('width');
			jQuery(this).removeAttr('height');
			
				new_height = content_width/aspect_ratio;
				jQuery(this).width(content_width+'px');
				jQuery(this).height(new_height);
				jQuery(this).addClass( 'resized aligncenter' )

			}
		});
	});
	
/*	-----------------------------------------------------------------------------------*/

	jQuery(function($) {
		
	/*-----------------------------------------------------------------------------------
	  Tabs shortcode
	-----------------------------------------------------------------------------------*/
		
		if ( jQuery( '.shortcode-tabs').length ) {	
			
			jQuery( '.shortcode-tabs').each( function () {
			
				var tabCount = 1;
			
				jQuery(this).children( '.tab').each( function ( index, element ) {
				
					var idValue = jQuery(this).parents( '.shortcode-tabs').attr( 'id' );
				
					var newId = idValue + '-tab-' + tabCount;
				
					jQuery(this).attr( 'id', newId );
					
					jQuery(this).parents( '.shortcode-tabs').find( 'ul.tab_titles').children( 'li').eq(index).find( 'a').attr( 'href', '#' + newId );
					
					tabCount++;
				
				});
			
				var thisID = jQuery(this).attr( 'id' );
			
				jQuery(this).tabs( { fx: { opacity: 'toggle', duration: 200 } } );
			
			});


		} // End IF Statement
		
	/*-----------------------------------------------------------------------------------
	  Toggle shortcode
	-----------------------------------------------------------------------------------*/
		
		if ( jQuery( '.shortcode-toggle').length ) {	
			
			jQuery( '.shortcode-toggle').each( function () {
				
				var toggleObj = jQuery(this);
				
				toggleObj.closedText = toggleObj.find( 'input[name="title_closed"]').attr( 'value' );
				toggleObj.openText = toggleObj.find( 'input[name="title_open"]').attr( 'value' );
				
				// Add logic for the optional excerpt text.
				if ( toggleObj.find( 'a.more-link.read-more' ).length ) {
					toggleObj.readMoreText = toggleObj.find( 'a.more-link.read-more' ).text();
					toggleObj.readLessText = toggleObj.find( 'a.more-link.read-more' ).attr('readless');
					toggleObj.find( 'a.more-link.read-more' ).removeAttr('readless');
					
					toggleObj.find( 'a.more-link' ).click( function () {
						
						var moreTextObj = jQuery( this ).next( '.more-text' );
						
						moreTextObj.animate({ opacity: 'toggle', height: 'toggle' }, 300).css( 'display', 'block' );
						moreTextObj.toggleClass( 'open' ).toggleClass( 'closed' );
						
						if ( moreTextObj.hasClass( 'open') ) {
						
							jQuery(this).text(toggleObj.readLessText);
						
						} // End IF Statement
						
						if ( moreTextObj.hasClass( 'closed') ) {
						
							jQuery(this).text(toggleObj.readMoreText);
						
						} // End IF Statement
						
						return false;
					});
				}
				
				toggleObj.find( 'input[name="title_closed"]').remove();
				toggleObj.find( 'input[name="title_open"]').remove();
				
				toggleObj.find( 'h4.toggle-trigger a').click( function () {
				
					toggleObj.find( '.toggle-content').animate({ opacity: 'toggle', height: 'toggle' }, 300);
					toggleObj.toggleClass( 'open' ).toggleClass( 'closed' );
					
					if ( toggleObj.hasClass( 'open') ) {
					
						jQuery(this).text(toggleObj.openText);
					
					} // End IF Statement
					
					if ( toggleObj.hasClass( 'closed') ) {
					
						jQuery(this).text(toggleObj.closedText);
					
					} // End IF Statement
					
					return false;
				
				});
						
			});


		} // End IF Statement
		
	}); // jQuery()
	

/* Load the Share Buttons */
jQuery(window).load(function(){
    var shareCode = jQuery('#share-post').html();
    jQuery('div.share').html(shareCode);
    
    /* digg button */
    (function() {
        var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'http://widgets.digg.com/buttons.js';
        s1.parentNode.insertBefore(s, s1);
      })();
});

/* add arrow to the drop down */
function Mx_nav(){
    jQuery(".nav li ul").prev().addClass('add-arrow')
    jQuery(".nav li ul li ul").prev().removeClass('add-arrow').addClass('add-arrow-right')
}   
jQuery(window).load(function(){                   
	    Mx_nav();
	});