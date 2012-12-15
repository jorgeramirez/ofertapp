// Facebook auth
define( [ 'facebookuser' ],
  function( FacebookUser ) {
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
        alert( 'hellow FB user ');
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
