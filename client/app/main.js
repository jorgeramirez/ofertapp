require.config( {
  shim: {
    'backbone': {
      deps: [
        'underscore'
      ],
      exports: 'Backbone'
    }
  },
  paths: {
    'underscore': 'lib/lodash.min',
    'backbone': 'lib/backbone-0.9.2',
    'facebookuser': 'lib/FacebookUser',
    'text': 'lib/require/text'
  },
  baseUrl: 'client/app'
} );

require( 
  [ 'require', 'underscore', 'backbone' ],

  function( require, _, Backbone ) {
    // framework has been loaded
    
    window.SERVER_URL = '/server/index.php';
    //window.SERVER_URL = '/ofertapp/server/index.php';
    require( [ 'require',  'app'],
      function() {
        //ofertapp.utils.getCurrentPosition( function( pos ) {
          //ofertapp.currentPosition = pos;
        //}, window );
      }
    );
  }
);
