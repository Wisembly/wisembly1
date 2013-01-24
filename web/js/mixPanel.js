jQuery( document ).ready( function ($) {

  mixpanel.set_config({
    track_links_timeout: 2000
  });

  // event tracking contact email
  mixpanel.track_forms( "#send_contact_email", "corpo_send_contact_email", function ( ) {
    return {
      email: $( '#getName_email' ).val()
    };
  } );

  // event tracking freemium creation wish
  mixpanel.track_forms( "#free_trial_form", "corpo_create_wiz_freemium_button", function () {
    return {
      email:  $( '#free_trial_form_email' ).val()
    };
  } );

  // event tracking abo form
  mixpanel.track_forms( "#send_abo_email", "corpo_send_abo_email", function () {
    return {
      email: $( '#getName_email' ).val(),
      type: $( '#getName_type' ).val()
    }
  } );

  // track call to actions try button
  mixpanel.track_links( "#call-to-action-plans", "corpo_try_call_to_action" );

  var persistCampaign = {
     adwordsCampaign: getAdwordsCampaign()
   , entryPage: window.location.pathname
  };

  // persist once entryPage and adwordcampaign
  mixpanel.register_once( persistCampaign );

  if ( $( '#mixpanel_plans_page_tracker' ).length > 0 ) {
   mixpanel.track( 'corpo_visit_plans' );
   mixpanel.people.set( persistCampaign );
  }

  if ( $( '#mixpanel_discover_page_tracker' ).length > 0 ) {
   mixpanel.track( 'corpo_discover' );
   mixpanel.people.set( persistCampaign );
  }
} );

// @guillaumepotier indexOf implementation for IE<=8 support
String.prototype.indexOf = function ( str ) {
    var index = -1;

    for ( var i = 0; i < this.length; i++ ) {
        if ( this[i] === str[0] ) {
            index = i;

            for ( var j = 1; j < str.length; j++ ) {
                if ( this[i+j] !== str[j] ) {
                    i += j;
                    break;
                }
            }

            if ( i === index ) {
                return index;
            }
        }
    }

    return -1;
}

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
