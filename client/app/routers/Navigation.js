define(
  [ 'backbone', 'collections/Offers' ],
  function( Backbone, offers ) {
    
    var Navigation = Backbone.Router.extend( {
      routes: {
        'main': 'main',
        'category-selection': 'searchCategorySelection',
        'searchmap-results': 'searchMapResults',
        'index': 'index',
        'offer-details-:id': 'offerDetails',
        '': 'root',
        'seller-create' : 'sellerCreate',
        'offer-create' : 'offerCreate',
        'offer-create-final' : 'offerCreateFinal',
        'new-offer': 'newOffer'
      },

      root: function() {
        location.hash = 'index';
      },

      index: function() {
        new ofertapp.views.IndexPage();        
      },

      logout: function() {
        ofertapp.auth.facebook.logout();
      },

      main: function() {
        ofertapp.utils.changePage( '#main', 'slide', false, false );
      },

      searchCategorySelection: function() {
        new ofertapp.views.CategorySelection(); 
      },

      searchMapResults: function() {
        var checked = ofertapp.utils.getCategoriesChecked( '#category-selection input[type=checkbox]' );
        ofertapp.utils.changePage( '#searchmap-results', 'slide', false, false );
        new ofertapp.views.SearchMapResults( checked );
      },

      offerDetails: function( id ) {
        new ofertapp.views.OfferDetails( id );
      },

      sellerCreate: function(){
        ofertapp.utils.changePage('#seller-create', 'slide', false, true);
        new ofertapp.views.SellerCreate();
      },

      offerCreate: function(){
        new ofertapp.views.CreateOffer();
      },

      offerCreateFinal: function(){
        new ofertapp.views.OfferCreateFinal();
      },

      newOffer: function() {
        var data = {};
        $( '#offer-create form input' ).each( function() {
          data[ $( this ).attr( 'name' ) ] = $( this ).attr( 'value' );
        } );
        data.categoryId = $( '#offer-create form select' ).attr( 'value' );
        data.sellerId = $( '#offer-create-final form input[type=radio]' ).attr( 'value' );
        data.photo = '';
        data.userId = ofertapp.UserSession.get( 'idUser' );
        data.currency = "PYG";
        offers.create( data, {
          url: window.SERVER_URL + '/offer',
          success: function( col, response ) {
            console.log( 'created!!!' );
            console.log( response );
            ofertapp.utils.changePage( '#offer-details', 'slide', false, true );
            new ofertapp.views.OfferDetails( response.idOffer ); 
          },
          wait: true
        } );
      }

    } );

    return Navigation;
  }
);
