jQuery( document ).ready( function ($) {
  mixpanel.track_links( "#create_wiz_freemium", "corpo_create_wiz_freemium_button" );
  mixpanel.track_links( "#start_wiz", "corpo_create_wiz_button", function () { return { 'price': parseInt($( '#exact_computed_price' ).text()) } } );
  mixpanel.track_forms( "#send_contact_email", "corpo_send_contact_email", { 'email': $( '#getName_email' ).val() } );
  mixpanel.track_links( "#create_wiz_on_demand", "corpo_create_wiz_on_demand" );
  mixpanel.track_links( "#ask_for_a_licence", "corpo_ask_for_a_licence" );
  if ( $( '#mixpanel_plans_page_tracker' ).length !== 0 ) {
   mixpanel.track( 'corpo_visit_plans', { 'adwordsCampaign': getAdwordsCampaign() } );
   mixpanel.register( { 'adwordsCampaign': getAdwordsCampaign() } );
   mixpanel.people.set( { 'adwordsCampaign': getAdwordsCampaign() } );
  }
} );

function getAdwordsCampaign() {
  return -1 !== getCookie( '__utmz' ).indexOf( 'gclid' );
}

function getCookie( c_name ) {
  var i, x, y, ARRcookies = document.cookie.split( ';' );

  for ( i = 0; i < ARRcookies.length; i++ ) {
    x = ARRcookies[ i ].substr( 0, ARRcookies[ i ].indexOf( '=' ) );
    y = ARRcookies[ i ].substr( ARRcookies[ i ].indexOf( '=' ) + 1 );
    x = x.replace( /^\s+|\s+$/g, '' );

    if ( x == c_name ) {
      return unescape( y );
    }
  }
}
