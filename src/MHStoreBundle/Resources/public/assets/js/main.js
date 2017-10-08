$(function () {
    var jumboHeight = $('.jumbotron').outerHeight();
    function parallax(){
        var scrolled = $(window).scrollTop();
        $('.bg').css('height', (jumboHeight-scrolled) + 'px');
    }

    $(window).scroll(function(e){
        parallax();
    });


    $("#searchButton").click(function () {
        var word = $("#searchText").val();
        var url = Routing.generate('mh_store_search', { tag: word });
        window.location.href = url;
    });

    $( "#searchText" ).keypress(function(e) {
        if ( e.which == 13 ) {
            e.preventDefault();
            var word = $("#searchText").val();
            var url = Routing.generate('mh_store_search', { tag: word });
            window.location.href = url;
        }
    });
});