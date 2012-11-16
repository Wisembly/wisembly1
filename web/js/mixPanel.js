jQuery( document ).ready( function ($) {
  mixpanel.track_links( "#create_wiz_freemium", "corpo_create_wiz_freemium_button" );
  mixpanel.track_links( "#start_wiz", "corpo_create_wiz_button", function () { return { 'price': $( '#exact_computed_price' ).text() } } );
  mixpanel.track_links( "#send_contact_email", "corpo_send_contact_email", { 'email': $( '#getName_email' ).val() } );
  mixpanel.track_links( "#create_wiz_on_demand", "corpo_create_wiz_on_demand" );
  mixpanel.track_links( "#ask_for_a_licence", "corpo_ask_for_a_licence" );
} );