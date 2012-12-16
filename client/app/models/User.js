define(
  [ 'backbone' ],
  function( Backbone ) {
    var User = Backbone.Model.extend( {
      idAttribute: 'idUser',
      defaults: {
        idUser: null
      },

      url: window.SERVER_URL + '/user'
    } );

    return User;
  }
);
