define( 
  [ 
    'backbone', 'routers/Navigation', 'helpers/utils', 'helpers/auth/Facebook',
    'views/SearchMapResults', 'views/IndexPage'
  ],
  
  function( Backbone, NavigationRouter, utils, FacebookAuth, 
            SearchMapResults, IndexPage ) {
    $(function() {
      
      window.ofertapp = window.ofertapp || {
        views: {
          SearchMapResults: SearchMapResults,
          IndexPage: IndexPage
        },
        models: {},
        collections: {},
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
        }
      };
      
      //ofertapp.auth.facebook.init();
      Backbone.history.start();
    });
  }
);
