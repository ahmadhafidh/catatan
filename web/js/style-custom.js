$(document).ready(function(){
    doPickadate()
    $(".clickable-row").click(function () {
        window.location = $(this).data("href");
    });
})