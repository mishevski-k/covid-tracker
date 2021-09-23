if ( window.history.replaceState ) {  
    window.history.replaceState( null, null, window.location.href );
}

$(document).ready(function(){

    $(".nav-menu").click(function(){
        if($(".nav-links").css("display") === "none") {
            $(".nav-links").css("display", "block");
            $("nav").addClass("active");
            $(".nav-menu i").removeClass("gg-menu");
            $(".nav-menu i").addClass("gg-close");
            $(".main-container").addClass("active");
        } else {
            $(".nav-links").css("display", "none");
            $("nav").removeClass("active");
            $(".nav-menu i").addClass("gg-menu");
            $(".nav-menu i").removeClass("gg-close");
            $(".main-container").removeClass("active");
        }
    });

    $("#toggle-info").click(function(){
        if($(".cases-info").css("display") === "none"){
            $(".cases-info").css("display", "flex");
            $("#toggle-info").removeClass("gg-arrow-down-o");
            $("#toggle-info").addClass("gg-arrow-up-o");
        } else {
            $(".cases-info").css("display", "none");
            $("#toggle-info").addClass("gg-arrow-down-o");
            $("#toggle-info").removeClass("gg-arrow-up-o");
        }
    });

    $("#toggle-table-confirmed").click(function(){
        if($("#table-confirmed").css("display") === "none") {
            $("#table-confirmed").css("display", "table");
            $("#toggle-table-confirmed").removeClass("gg-arrow-down-o");
            $("#toggle-table-confirmed").addClass("gg-arrow-up-o");
        } else {
            $("#table-confirmed").css("display", "none")
            $("#toggle-table-confirmed").addClass("gg-arrow-down-o");
            $("#toggle-table-confirmed").removeClass("gg-arrow-up-o");
        }
    });

    $("#toggle-table-deaths").click(function(){
        if($("#table-deaths").css("display") === "none") {
            $("#table-deaths").css("display", "table");
            $("#toggle-table-deaths").removeClass("gg-arrow-down-o");
            $("#toggle-table-deaths").addClass("gg-arrow-up-o");
        } else {
            $("#table-deaths").css("display", "none")
            $("#toggle-table-deaths").addClass("gg-arrow-down-o");
            $("#toggle-table-deaths").removeClass("gg-arrow-up-o");
        }
    });

    $("#toggle-table-recovered").click(function(){
        if($("#table-recovered").css("display") === "none") {
            $("#table-recovered").css("display", "table");
            $("#toggle-table-recovered").removeClass("gg-arrow-down-o");
            $("#toggle-table-recovered").addClass("gg-arrow-up-o");
        } else {
            $("#table-recovered").css("display", "none")
            $("#toggle-table-recovered").addClass("gg-arrow-down-o");
            $("#toggle-table-recovered").removeClass("gg-arrow-up-o");
        }
    });
});