define(
  [ 'backbone' ],
  function( Backbone ) {
    var IndexPage = Backbone.View.extend( {
      el: '#index',

      events: {
        'click a[data-role=button]': 'loginHandler' 
      },

      initialize: function() {
        //ofertapp.auth.facebook.init();
      },

      loginHandler: function() {
        console.log( 'hola' );
        ofertapp.auth.facebook.init();
      }
    } );
    
    return IndexPage;
  }
);
