define(
  [ 'backbone' ],
  function( Backbone ) {
    
    var Navigation = Backbone.Router.extend( {
      routes: {
        ':category': 'category',
        '': 'root' 
      },

      category: function( name ) {
        console.log( name );
      },

      root: function() {
        location.hash = 'index';
      }
    } );

    return Navigation;
  }
);
