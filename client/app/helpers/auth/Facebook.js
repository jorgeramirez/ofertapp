// Facebook auth
define( [ 'facebookuser', 'models/User' ],
  function( FacebookUser, User ) {
    var user;
    var Facebook = {}; 
    
    Facebook.init = function() {
      FB.init( ofertapp.defaults.FB.INIT_PARAMS );
      
      user = new FacebookUser(null, {
        scope: ofertapp.defaults.FB.SCOPE
      });
      
      user.on('facebook:unauthorized', function(model, response) {
        console.log( "facebook:unauthorized" );
        user.login();
      });

      user.on('facebook:connected', function(model, response) {
        console.log( "facebook:connected" );
        location.hash = 'main';
        ofertapp.FbAuthResponse = response.authResponse;

        var appUser = ofertapp.UserSession = new User( {
          userIDFb: response.authResponse.userID
        } );

        appUser.fetch( {
          url: appUser.url + '/oauth/' + response.authResponse.userID,
          success: onSuccess,
          error: onFailure
        } );

        function onSuccess( model, exists ) {
          if( exists ) {
            console.log( appUser );
          }else{
            ofertapp.UserSession = new User( {
              userIDFb: response.authResponse.userID
            } );
            ofertapp.UserSession.save();
          }
        }

        // user does not exits, create one
        function onFailure() {
        }

        ofertapp.utils.changePage( '#main', 'slide', false, false );
      });

      user.on('facebook:disconnected', function(model, response) {
        console.log( "facebook:disconnected" );
        user.login();
      });

      user.updateLoginStatus();
    };

    Facebook.logout = function() {
      user.logout();
    };

    return Facebook;
  }
);
