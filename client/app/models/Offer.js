define(
  [ 'backbone' ],
  function( Backbone ) {
    var Offer = Backbone.Model.extend( {
      idAttribute: 'idOffert',
      defaults: {
        idOffert: null
      } 
    } );

    return Offer;
  }
);
