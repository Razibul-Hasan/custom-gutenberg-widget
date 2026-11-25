/**
 * GA4 conversion events: contact form sent, WhatsApp / email / free-audit / pricing / plugin-download clicks.
 * No personal data is sent. Uses gtag() from Google Site Kit, or the dataLayer as a fallback.
 */
( function () {
	'use strict';

	function send( name, params ) {
		params = params || {};
		params.page_path = window.location.pathname;
		if ( typeof window.gtag === 'function' ) {
			window.gtag( 'event', name, params );
		} else {
			window.dataLayer = window.dataLayer || [];
			window.dataLayer.push( Object.assign( { event: name }, params ) );
		}
	}

	// Contact Form 7: message sent successfully.
	document.addEventListener( 'wpcf7mailsent', function ( e ) {
		send( 'generate_lead', { form_id: String( ( e.detail && e.detail.contactFormId ) || '' ) } );
	} );

	// Link clicks, one listener for the whole page.
	document.addEventListener( 'click', function ( e ) {
		var a = e.target.closest ? e.target.closest( 'a[href]' ) : null;
		if ( ! a ) {
			return;
		}
		var href = a.getAttribute( 'href' ) || '';
		var text = ( a.textContent || '' ).replace( /\s+/g, ' ' ).trim().toLowerCase();

		if ( /^https?:\/\/(wa\.me|api\.whatsapp\.com)\//i.test( href ) ) {
			send( 'whatsapp_click' );
		} else if ( /^mailto:/i.test( href ) ) {
			send( 'email_click' );
		} else if ( /wordpress\.org\/plugins\//i.test( href ) ) {
			send( 'plugin_download_click', { link_url: href } );
		} else if ( /audit/.test( text ) ) {
			send( 'audit_cta_click', { link_text: text.slice( 0, 60 ) } );
		} else if ( /\/pricing\/?(#|$)/.test( href ) || /see (pricing|packages)|choose /.test( text ) ) {
			send( 'pricing_cta_click', { link_text: text.slice( 0, 60 ) } );
		}
	}, true );
}() );
