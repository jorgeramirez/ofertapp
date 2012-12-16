define(
  [ 'backbone', 'collections/Categories', 'text!templates/createOffer.html' ],
  function( Backbone, categories, createOfferTpl ) {
    var CreateOffer = Backbone.View.extend( {
      el: '#offer-create',
      
      collection: categories,

      template: _.template( createOfferTpl ),

      initialize: function() {
        var me = this;
        
        function onSuccess( collection, response ) {
          me.renderForm();
        }

        function onFailure( collection, response ) {
          console.log( 'categories fetch failed!' ); 
        }

        me.collection.fetch( {
          success: onSuccess,
          error: onFailure
        } );
      },

      renderForm: function() {
        var me = this;
        
        me.$( 'div.placeholder' ).replaceWith( me.template( { categories: me.collection.toJSON() } ) );
        ofertapp.utils.changePage( '#offer-create', 'slide', false, false );
      }
    } );
    
    return CreateOffer;
  }
);
