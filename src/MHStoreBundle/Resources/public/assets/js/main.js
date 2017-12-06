$(function () {
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