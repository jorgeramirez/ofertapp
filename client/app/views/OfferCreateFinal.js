define(
  [ 'backbone', 'collections/Sellers', 'text!templates/offerCreateFinal.html' ],
  function( Backbone, sellers, offerCreateFinalTpl ) {
    var OfferCreateFinal = Backbone.View.extend( {
      el: '#offer-create-final',
      
      template: _.template( offerCreateFinalTpl ),

      initialize: function( collection, keep ) {
        var me = this;

        me.collection = collection || sellers;
        
        if( keep ){ //collection is already synced
          me.renderSellers();
          return;
        } 
        
        function onSuccess( collection, response ) {
          me.renderSellers();
        }

        function onFailure( collection, response ) {
          console.log( 'categories fetch failed!' ); 
        }

        me.collection.fetch( {
          success: onSuccess,
          error: onFailure,
          url: me.collection.url + ofertapp.currentPosition.coords.latitude + '/' + 
               ofertapp.currentPosition.coords.longitude
        } );
      },

      renderSellers: function() {
        var me = this;
        
        me.$( 'div.placeholder' ).empty().append( me.template( { sellers: me.collection.toJSON() } ) );
        
        ofertapp.utils.changePage( '#offer-create-final', 'none', false, true );
      }
    } );
    
    return OfferCreateFinal;
  }
);
