var go = (function (app) {

  app.init = function(){
    // __constructer
    app.doIt();
    return app;
  }

  app.doIt = function() {
    console.log(app.test);
  }

  return app.init();
})
var g = new go({"test":"true"});
