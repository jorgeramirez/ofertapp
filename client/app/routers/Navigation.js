define(
  [ 'backbone' ],
  function( Backbone ) {
    
    var Navigation = Backbone.Router.extend( {
      routes: {
        'main': 'main',
        '': 'root' 
      },

      root: function() {
        location.hash = 'index';
      },

      main: function() {
        ofertapp.utils.changePage( '#main', 'slide', false, false );
      }
    } );

    return Navigation;
  }
);
