console.log("okok")

$("nav .navbar-nav .nav-item").on("click",function(e){
    console.log("ok")
    $("nav .navbar-nav .nav-item").each(function(){
        if($("nav .navbar-nav .nav-item").hasClass("active")){
            $(this).removeClass("active")
        }
    })
    $(this).addClass("active")

    $("nav .navbar-toggler").addClass("collapsed")
    $("nav .navbar-collapse").removeClass("show")
})