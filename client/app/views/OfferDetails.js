define(
  [ 'backbone', 'text!templates/offerDetails.html', 'collections/Offers' ],
  function( Backbone, offerDetailsTpl, offers ) {
    var OfferDetails = Backbone.View.extend( {
      el: '#offer-details',

      template: _.template( offerDetailsTpl ),

      events: {
      },

      initialize: function( id ) {
        this.model = offers.get( id ).toJSON();
        this.render();
      },

      render: function() {
        this.$( 'div.placeholder' ).empty().append( this.template( { offer :this.model } ) );  
        ofertapp.utils.changePage( '#offer-details', 'slide', false, false );
      }

    } );
    
    return OfferDetails;
  }
);
