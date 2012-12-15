define(
  [  ],
  function( ) {
    var utils = {};    
    
    // summary:
    //            A convenience method for accessing $mobile.changePage(), included
    //            in case any other actions are required in the same step.
    // changeTo: String
    //            Absolute or relative URL. In this app references to '#index', '#search' etc.
    // effect: String
    //            One of the supported jQuery mobile transition effects
    // direction: Boolean
    //            Decides the direction the transition will run when showing the page
    // updateHash: Boolean
    //            Decides if the hash in the location bar should be updated

    utils.changePage = function( viewID, effect, direction, updateHash ) {
        $.mobile.changePage( viewID, { transition: effect, reverse:direction, changeHash: updateHash} );
    };
    
    return utils;
  }
);
