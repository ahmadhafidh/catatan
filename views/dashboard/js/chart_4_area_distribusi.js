$(function () {
    function getData(callback) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var _year = urlParams.get('year');	
        var _kejaksaanId = urlParams.get('kejaksaan_id');

        runAjax(_year, callback, _kejaksaanId)
    }

    function runAjax(year, callback, kejaksaanId) {
        var data;

        $.ajax({
            type: "POST",
            url: '/dashboard/areadistribusi?year=' + year + '&kejaksaan_id=' + kejaksaanId,
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                data = response;
                callback(data);
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
        return data;
    }

    getData(function (dt) {
        // console.log(dt);

        $('#Stack-bar-chart2').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '',
                x: -20
            },
            xAxis: {
                visible: false,
            },
            yAxis: {
                visible: false,
            },
            legend: {
                align: 'right',
                verticalAlign: 'top',
                layout: 'vertical'
            },
            tooltip: {
                pointFormatter: function () {
                    var value = this.y + '%'
                    return '<span style="color:' + this.series.color + '">' + this.series.name + '</span>: <b>' + value + '</b><br />'
                },
                headerFormat: '',
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return this.y + "%";
                        }
                    }
                },
            },
            colors: ["#F86056", "#F8CC44", "#75CC35", "#27AFC3", "#A544B9", "#121212"],
            credits: {
                enabled: false
            },
            series: dt
        });
    });
});