define(
  [ 'backbone' ],
  function( Backbone ) {
    
    var Navigation = Backbone.Router.extend( {
      routes: {
        'main': 'main',
        'category-selection': 'searchCategorySelection',
        'searchmap-results': 'searchMapResults',
        'index': 'index',
        'offer-details': 'offerDetails',
        '': 'root',
        'seller-create' : 'sellerCreate',
        'offer-create' : 'offerCreate',
        'offer-create-final' : 'offerCreateFinal'
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
        ofertapp.utils.changePage( '#category-selection', 'slide', false, false );
      },

      searchMapResults: function() {
        ofertapp.utils.changePage( '#searchmap-results', 'slide', false, false );
        new ofertapp.views.SearchMapResults();
      },

      offerDetails: function() {
        ofertapp.utils.changePage( '#offer-details', 'slide', false, false );
      },

      sellerCreate: function(){
        ofertapp.utils.changePage('#seller-create', 'slide', false, false);
      },

      offerCreate: function(){
        ofertapp.utils.changePage('#offer-create', 'slide', false, false);
      },

      offerCreateFinal: function(){
        ofertapp.utils.changePage('#offer-create-final', 'slide', false, false);
      }

    } );

    return Navigation;
  }
);
