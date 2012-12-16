define(
  [ 'backbone', 'collections/Categories', 'text!templates/categoryList.html' ],
  function( Backbone, Categories, categoryListTpl ) {
    var CategorySelection = Backbone.View.extend( {
      el: '#category-selection',
      
      collection: Categories,

      categoriesTpl: _.template( categoryListTpl ),

      events: {
      },

      initialize: function() {
        var me = this;
        
        function onSuccess( collection, response ) {
          me.renderCategories();
        }

        function onFailure( collection, response ) {
          console.log( 'categories fetch failed!' ); 
        }

        me.collection.fetch( {
          success: onSuccess,
          error: onFailure
        } );
      },

      renderCategories: function() {
        var me = this;
        
        me.$( 'div.placeholder' ).replaceWith( me.categoriesTpl( { categories: me.collection.toJSON() } ) );
        ofertapp.utils.changePage( '#category-selection', 'none', false, false );
      }
    } );
    
    return CategorySelection;
  }
);
