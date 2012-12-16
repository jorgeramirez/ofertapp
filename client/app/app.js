define( 
  [ 
    'backbone', 'routers/Navigation', 'helpers/utils', 'helpers/auth/Facebook',
    'views/SearchMapResults', 'views/IndexPage', 'views/CategorySelection',
    'views/OfferDetails',
    'models/Category'
  ],
  
  function( Backbone, NavigationRouter, utils, FacebookAuth, 
            SearchMapResults, IndexPage, CategorySelection,
            OfferDetails,
            Category ) {
    $(function() {
      
      window.ofertapp = window.ofertapp || {
        views: {
          SearchMapResults: SearchMapResults,
          IndexPage: IndexPage,
          CategorySelection: CategorySelection,
          OfferDetails: OfferDetails
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
              appId: '452513154816194',
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
      
      //ofertapp.auth.facebook.init();
      Backbone.history.start();
    });
  }
);
