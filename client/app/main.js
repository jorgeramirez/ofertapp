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
    'facebookuser': 'lib/FacebookUser'
  },
  baseUrl: 'client/app'
} );

require( 
  [ 'require', 'underscore', 'backbone' ],

  function( require, _, Backbone ) {
    // framework has been loaded

    require( [ 'require',  'app'],
      function() {
      }
    );
  }
);
