define(
  [ 'backbone' ],
  function( Backbone ) {
    var SearchMapResults = Backbone.View.extend( {
      el: '#searchmaps-result',

      initialize: function() {
        var me = this;

        $( function() {
          ofertapp.utils.getCurrentPosition( me.locationHandler, me );
        } );
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
          me.drawMarkers( mapOpts.center, map );
        } );
      },

      drawMarkers: function( pos, map ) {
        var marker = ofertapp.utils.markerFactory( pos, map, 'hello' );
        var content = '<div class="info-window"><strong>Producto Uno</strong><hr><p>Precio: 1000 Gs </p> <a href="#offer-details">Ver Oferta</a></div>';
        var infoWindow = ofertapp.utils.infoWindowsFactory( content );
        google.maps.event.addListener( marker, 'click', function() {
          infoWindow.open( map, marker );
        } );
      }
    } );
    
    return SearchMapResults;
  }
);
