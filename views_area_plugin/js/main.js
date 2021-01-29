Drupal.behaviors.myBehavior = {
  attach: function (context, settings) {

    document.getElementById("myRange").onchange = myfunc

    function myfunc() {
      let slider = document.getElementById("myRange").value
      let linkTo = document.getElementById("link").innerHTML

      let pathToFuture = window.location.href.includes("future")
      let pathToPast = window.location.href.includes("past")

      if(pathToFuture) {
        if (slider > 60) {
          document.location.href=linkTo;
        }
      } else if(pathToPast) {
        if (slider < 40) {
          document.location.href=linkTo;
        }
      }
    }

  }
};

