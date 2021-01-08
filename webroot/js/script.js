console.log("script");

window.onload = function(){
 $("#darkTrigger").click(function(){
  if ($("body").hasClass("dark")){
    $("body").removeClass("dark");
    $("main").removeClass("dark");
    $(".content").removeClass("dark");
    $(".employees").removeClass("dark");
    $(".navbar").removeClass("dark");
    $(".navbar").removeClass("bg-secondary");
    $(".navbar").removeClass("navbar-secondary");
    $("footer").removeClass("bg-secondary");
    $("footer").addClass("bg-light");
    $(".navbar").addClass("bg-light");
    $(".navbar").addClass("navbar-light");
  }
  else{
    $("body").addClass("dark");
    $("main").addClass("dark");
    $(".employees").addClass("dark");
    $(".content").addClass("dark");
    $(".navbar").removeClass("bg-light");
    $(".navbar").removeClass("navbar-light");
    $(".navbar").addClass("bg-secondary");
    $(".navbar").addClass("navbar-secondary");
    $("footer").removeClass("bg-light");
    $("body > footer").removeClass("bg-light");
    $("footer").addClass("bg-secondary");
    $("body > footer").addClass("bg-secondary");
  }
});

$(document).ready(function () {
  var d = new Date();
  var n = d.getHours();

  if(n > 17 || n < 8){
    $("body").addClass("dark");
    $("main").addClass("dark");
    $(".employees").addClass("dark");
    $(".content").addClass("dark");
    $(".navbar").addClass("bg-secondary");
    $(".navbar").addClass("navbar-secondary");
    $("footer").addClass("bg-secondary");
    $("body > footer").addClass("bg-secondary");
  }
});  

};






