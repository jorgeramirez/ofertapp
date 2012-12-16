define(
  [ 'backbone', 'models/Category' ],
  function( Backbone, Category ) {
    var Categories = Backbone.Collection.extend( {
      model: Category,
      
      url: window.SERVER_URL + '/category',
      
      parse: function( response ) {
        return response.Category;
      }
    } );


    return new Categories();
  }
);
