define(
  [ 'backbone' ],
  function( Backbone ) {
    var Seller = Backbone.Model.extend( {
      idAttribute: 'idSeller',
      defaults: {
        idSeller: null
      } 
    } );

    return Seller;
  }
);
