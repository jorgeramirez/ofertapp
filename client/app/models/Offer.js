define(
  [ 'backbone' ],
  function( Backbone ) {
    var Offer = Backbone.Model.extend( {
      idAttribute: 'idOffer',
      defaults: {
        idOffer: null
      } 
    } );

    return Offer;
  }
);
