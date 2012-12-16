define(
  [ 'backbone', 'collections/Offers', 'text!templates/offerInfoWindow.html' ],
  function( Backbone, offers, infoWindowTpl ) {
    var SearchMapResults = Backbone.View.extend( {
      el: '#searchmaps-result',
      
      collection: offers,

      offerInfoWindowTpl: _.template( infoWindowTpl ),

      initialize: function( categories ) {
        var me = this;
        
        me.categories = categories;
        $( function() {
          ofertapp.utils.getCurrentPosition( me.locationHandler, me );
        } );

        //me.collection.on( 'change', me.onModelAdd, me);
      },

      locationHandler: function( pos ) {
        var me = this;
        var mapOpts = {
            center: new google.maps.LatLng( pos.coords.latitude, pos.coords.longitude ),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = ofertapp.currentMap = new google.maps.Map( document.getElementById( 'map-canvas' ), mapOpts );
        google.maps.event.addListenerOnce( map, 'idle', function() { 
          google.maps.event.trigger( ofertapp.currentMap,'resize' );
          
          me.collection.reset();
          
          me.categories.forEach( function( id ) {
            
            me.collection.fetch({
              success: function( c ) {
                if( c.length === 0 ){
                  return;
                }
                me.drawMarkers( mapOpts.center, map, c.toJSON() );
              },
              error: function( c ) {
                console.log( 'error!!!!' );
              },
              url: me.collection.url + id
            });
          } );
          
          //me.drawMarkers( mapOpts.center, map );
        } );
      },

      onModelAdd: function( model ) {
        console.log( model ); 
      },

      drawMarkers: function( pos, map, collection ) {
        var me = this;
        
        function aux( offer ) {
          var marker = ofertapp.utils.markerFactory( pos, map, offer.offerName );
          var content = me.offerInfoWindowTpl( { offer: offer } );
          var infoWindow = ofertapp.utils.infoWindowsFactory( content );
          
          google.maps.event.addListener( marker, 'click', function() {
            infoWindow.open( map, marker );
          } );
        }

        collection.forEach( function( offer ) {
          aux( offer );
        } );
      }
    } );
    
    return SearchMapResults;
  }
);
