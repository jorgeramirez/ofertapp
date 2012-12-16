define(
  [ 'backbone' ],
  function( Backbone ) {
    var Category = Backbone.Model.extend( {
      idAttribute: 'idCategory',
      defaults: {
        idCategory: null,
        categoryName: '',
        smallPhoto: null,
        photo: null
      } 
    } );

    return Category;
  }
);
