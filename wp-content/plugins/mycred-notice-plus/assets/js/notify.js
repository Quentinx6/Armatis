( function( $ ) {

	$.extend({

		noticeAdd : function( options ) {

			var defaults = {
				inEffect :         { opacity: 'show' },
				inEffectDuration : 600,
				stayTime :         parseInt( myCRED_Notice.duration, 10 ),
				text :             '',
				stay :             true,
				type :             'positive',
				classes :          'notice-item'
			}

			var options, noticeWrapAll, noticeItemOuter, noticeItemInner, noticeItemClose;

			options 		= $.extend( {}, defaults, options );
			noticeWrapAll	= $( '#mycred-notificiation-wrap' );
			noticeItemOuter	= $( '<div></div>' ).addClass( 'notice-item-wrapper' );
			noticeItemInner	= $( '<div></div>' ).hide().addClass( options.classes + ' ' + options.type ).appendTo( noticeWrapAll ).append( options.text ).animate( options.inEffect, options.inEffectDuration ).wrap( noticeItemOuter );
			noticeItemClose	= $( '<div></div>' ).addClass( 'notice-item-close' ).prependTo( noticeItemInner ).html( '&times;' ).click(function() { $.noticeRemove( noticeItemInner ) });

			if ( navigator.userAgent.match(/MSIE 6/i) ) {
				noticeWrapAll.css({top: document.documentElement.scrollTop});
			}

			if ( ! options.stay ) {
				setTimeout(function() {
					$.noticeRemove( noticeItemInner );
				}, options.stayTime );
			}

		},

		noticeRemove : function( obj ) {
			obj.animate({ opacity: '0' }, 200, function() {
				obj.parent().animate({ height: '0px' }, 100, function() {
					obj.parent().remove();
				});
			});
		}

	});

	var gettingnotice     = false;
	var mycred_get_notice = function() {

		if ( gettingnotice ) return false;
		gettingnotice = true;

		console.log( 'Instant Notifications: Checking for new notifications' );

		$.ajax({
			type     : "POST",
			data     : {
				action  : 'mycred-inotify',
				token   : myCRED_Notice.token
			},
			dataType : "JSON",
			url      : myCRED_Notice.ajaxurl,
			success  : function( response ) {

				if ( response !== undefined && response !== null && response != '' ) {

					if ( myCRED_Notice.debug == 'yes' ) console.log( response );

					$.each( response, function( index, note ){
						if ( myCRED_Notice.duration > 0 )
							$.noticeAdd({ text: note.text, stay: false, type: note.type, classes: note.classes });
						else
							$.noticeAdd({ text: note.text, stay: true, type: note.type, classes: note.classes });
					});

				}
				else if ( myCRED_Notice.debug == 'yes' ) console.log( 'Instant Notifications: no new messages found' );

				gettingnotice = false;

			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log( 'Instant Notifications: Communications error!' );
				if ( myCRED_Notice.debug == 'yes' ) {
					console.log( xhr.responseText );
					console.log( thrownError );
				}
			}
		});

	};

	$(document).ready(function(){

		if ( myCRED_Notice.notices.length > 0 ) {

			if ( myCRED_Notice.debug == 'yes' ) console.log( myCRED_Notice.notices );

			$.each( myCRED_Notice.notices, function( index, note ){
				if ( myCRED_Notice.duration > 0 )
					$.noticeAdd({ text: note.text, stay: false, type: note.type, classes: note.classes });
				else
					$.noticeAdd({ text: note.text, stay: true, type: note.type, classes: note.classes });
			});

		}

		if ( myCRED_Notice.instant == '1' ) {

			if ( myCRED_Notice.debug == 'yes' ) console.log( 'Instant Notifications: Enabled Refresh rate: ' + myCRED_Notice.frequency + ' ms.' );

			window.setInterval(function(){
				mycred_get_notice();
			}, myCRED_Notice.frequency );

		}
		else if ( myCRED_Notice.debug == 'yes' ) console.log( 'Instant Notifications: Disabled.' );

	});

} )( jQuery );