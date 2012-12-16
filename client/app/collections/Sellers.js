define(
  [ 'backbone', 'models/Seller' ],
  function( Backbone, Seller ) {
    var Sellers = Backbone.Collection.extend( {
      model: Seller,
      
      url: window.SERVER_URL + '/seller/close/',
      
      parse: function( response ) {
        return response.Seller;
      }
    } );


    return new Sellers();
  }
);
