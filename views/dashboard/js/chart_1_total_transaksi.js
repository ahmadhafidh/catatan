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
            url: '/dashboard/transaksitotal?year=' + year + '&kejaksaan_id=' + kejaksaanId,
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
        $('#line-area1').highcharts({
            chart: {
                type: 'areaspline'
            },
            title: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"]
            },
            yAxis: {
                title: {
                    text: 'Total Transaksi'
                }
            },
            tooltip: {
                pointFormatter: function () {
                    var value;
                    if (this.y >= 0) {
                        value = 'Rp. ' + formatRupiah(this.y)
                    } else {
                        value = '-Rp. ' + (-this.y)
                    }
                    return '<span style="color:' + this.series.color + '">' + this.series.name + '</span>: <b>' + value + '</b><br />'
                },
                shared: true
            },
            credits: {
                enabled: false
            },
            colors: ['#0EA750'],
            legend: {
                align: 'left',
                verticalAlign: 'top',
                layout: 'horizontal'
            },
            series: [{
                name: 'Total Transaksi',
                data: dt
            }]
        });
    });

    function formatRupiah(bilangan) {
        var number_string = bilangan.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }
});