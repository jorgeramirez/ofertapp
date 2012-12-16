define(
  [ 'backbone', 'models/Offer' ],
  function( Backbone, Offer ) {
    var Offers = Backbone.Collection.extend( {
      model: Offer,
      
      url: window.SERVER_URL + '/offer/recent/category/',
      
      parse: function( response ) {
        return response.Offer;
      }
    } );


    return new Offers();
  }
);
