define(
  [ 'backbone', 'collections/Sellers', 'views/OfferCreateFinal',
    'collections/Offers'],
  function( Backbone, sellers, OfferCreateFinal, offers ) {
    var SellerCreate = Backbone.View.extend( {
      el: '#seller-create',

      events: {
        'click a[data-role=button]': 'createSeller'        
      },

      createSeller: function() {
        var data = {};
        data.sellerName = this.$( 'input[name=sellerName]' ).attr( 'value' );
        data.latitude = ofertapp.currentPosition.coords.latitude;
        data.longitude = ofertapp.currentPosition.coords.longitude;

        sellers.create( data, {
          url: window.SERVER_URL + '/seller',
          success: function( collection, response ) {
            
            // just create the offer
            var data = {};
            $( '#offer-create form input' ).each( function() {
              data[ $( this ).attr( 'name' ) ] = $( this ).attr( 'value' );
            } );
            data.categoryId = $( '#offer-create form select' ).attr( 'value' );
            data.sellerId = response.idSeller;
            data.photo = '';
            data.userId = ofertapp.UserSession.get( 'idUser' );
            data.currency = "PYG";
            offers.create( data, {
              url: window.SERVER_URL + '/offer',
              success: function( col, response ) {
                ofertapp.utils.changePage( '#offer-details', 'slide', false, true );
                new ofertapp.views.OfferDetails( response.idOffer ); 
              },
              wait: true
            } );
            
            //new OfferCreateFinal( sellers, true );
          },

          error: function() {
            console.log( 'error!!!!' );
          },
          wait: true
        });
      }

    } );
    
    return SellerCreate;
  }
);
