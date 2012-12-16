define(
  [ 'backbone', 'models/Offer' ],
  function( Backbone, Offer ) {
    var Offers = Backbone.Collection.extend( {
      model: Offers,
      
      url: window.SERVER_URL + '/offert/category/',
      
      parse: function( response ) {
        return response.Offert;
      }
    } );


    return new Offers();
  }
);
