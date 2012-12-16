define( 
  [ 
    'backbone', 'routers/Navigation', 'helpers/utils', 'helpers/auth/Facebook',
    'views/SearchMapResults', 'views/IndexPage', 'views/CategorySelection',
    'views/OfferDetails', 'views/CreateOffer', 'views/OfferCreateFinal',
    'views/SellerCreate',
    'models/Category'
  ],
  
  function( Backbone, NavigationRouter, utils, FacebookAuth, 
            SearchMapResults, IndexPage, CategorySelection,
            OfferDetails, CreateOffer, OfferCreateFinal,
            SellerCreate,
            Category ) {
    $(function() {
      
      window.ofertapp = window.ofertapp || {
        views: {
          SearchMapResults: SearchMapResults,
          IndexPage: IndexPage,
          CategorySelection: CategorySelection,
          OfferDetails: OfferDetails,
          CreateOffer: CreateOffer,
          OfferCreateFinal: OfferCreateFinal,
          SellerCreate: SellerCreate
        },
        models: {
          Category: Category
        },
        collections: {
        },
        routers: {
          navigation: new NavigationRouter()
        },
        defaults: {
          FB: {
            INIT_PARAMS: {
              appId: '380110662082168',
              status: true,
              cookie: true,
              xfbml: true,
              oauth: true
            },
            SCOPE: [ 'email', 'publish_stream' ]
          }
        },
        utils: utils,
        auth: {
          facebook: FacebookAuth
        },
        serverUrl: '/index.php'
      };
      
      ofertapp.utils.getCurrentPosition( function( pos ) {
        
        ofertapp.currentPosition = pos;
        ofertapp.auth.facebook.init();
        Backbone.history.start();
      
      }, window );
    });
  }
);
