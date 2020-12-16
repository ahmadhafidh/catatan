$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var year = urlParams.get('year');	
    var kejaksaanId = urlParams.get('kejaksaan_id');

    $.ajax({
        type: "POST",
        url: '/dashboard/sidebardashboard?year=' + year + '&kejaksaan_id=' + kejaksaanId,
        data: {},
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {
            data = response;
            $("#sidebar-render").html(response.content);
            console.log(data)
        },

        tryCount: 0,
        retryLimit: 3,
        error: function (xhr, textStatus, errorThrown) {
            if (textStatus == 'timeout') {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    //try again
                    $.ajax(this);
                    return;
                }
                return;
            }
            if (xhr.status == 500) {
                //handle error
                console.log(textStatus);
            } else {
                //handle error
                console.log(textStatus);
            }
        }
    });
});