//Tap Toggle start
let tapToggleState = true
let isDragging = false
$('.tap-toggle').click(function(){
    tapToggleState = $(this).find('.tp-inp').prop("checked")
    tapToggleState = !tapToggleState
    $(this).find("input").prop("checked", tapToggleState)
    $(this).toggleClass("tp-checked")

})
// Tap Toggle end

$("document").ready(function(){
    getTotalCount()
    $("#psInput").change(function(){
        // $("#psForm").submit()
        let val = $(this).val()
        window.location.href = getUrl("pageSize="+val)

    })
    let ref_open = getUrlParameter('ref_open')
    if (ref_open) {
        try {
            openModal(atob(ref_open))
        } catch (error) {
            window.history.replaceState({}, document.title, location.pathname); 
        }
    }
    
    $('#modal').on('hidden.bs.modal', function () {
        // window.history.back()
        window.history.replaceState({}, document.title, location.pathname);
    });
})
var arr_fee = {
    fee_spe: parseInt($('#fee_spe').val()) || 0,
    fee_bni: parseInt($('#fee_bni').val()) || 0
}
$('#fee_spe').change(function () {
    $(this).val(replace($(this).val()))
    arr_fee.fee_spe = parseInt($(this).val())
    $('#fee_total').val(array_sum(arr_fee))
})
$('#fee_bni').change(function () {
    $(this).val(replace($(this).val()))
    arr_fee.fee_bni = parseInt($(this).val())
    $('#fee_total').val(array_sum(arr_fee))
})
$('.money').maskMoney({
    prefix: 'Rp. ',
    precision: 0,
    allowZero:true
});
function formatTemplate(params) {
    if (!params.id) {
        return params.text
    }
    return $(
        `<span><i class="${params.id}" ></i> ${params.text}</span>`
    )
}

function CopyToClipboard(e, containerid) {
    var elm = document.getElementById(containerid);
    if (document.body.createTextRange) {
        var range = document.body.createTextRange();
        range.moveToElementText(elm);
        range.select();
        document.execCommand("Copy");
        // alert("Copied div content to clipboard");
        showTooltip(e, 'Copied')
    } else if (window.getSelection) {
        // other browsers

        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(elm);
        selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand("Copy");
        // alert("Copied div content to clipboard");
        showTooltip(e, 'Copied')
    }
}

function copyContent(e, containerid) {
    var elm = document.getElementById(containerid);
    if (document.body.createTextRange) {
        var range = document.body.createTextRange();
        range.moveToElementText(elm);
        range.select();
        document.execCommand("Copy");
        // alert("Copied div content to clipboard");
        changeColor(e)
    } else if (window.getSelection) {
        // other browsers

        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(elm);
        selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand("Copy");
        // alert("Copied div content to clipboard");
        changeColor(e)
    }
}

function array_sum(arr) {
    var sum = 0
    for (var el in arr) {
        sum += parseInt(arr[el])
    }
    return sum
}

function showTooltip(e, txt) {
    $(e).attr('data-title', txt)
    $(e).attr('data-toggle', 'tooltip')
    $(e).attr('data-placement', 'top')
    $(e).attr('data-trigger', 'manual')
    $(e).tooltip('show');
    $(e).blur(function () {
        $(e).tooltip('hide')
    })
    setTimeout(function(){
        $(e).tooltip('hide')
    }, 500)
}

function changeColor(e) {
    $(e).attr('class', 'btn btn-success btn-sm')
    $(e).text('Copied')
    $(e).focus()
    $(e).blur(function () {
        $(e).attr('class', 'btn btn-light btn-sm')
        $(e).text('Copy')
    })
}

function replace(str) {
    str = str.replace(new RegExp("Rp. ", "g"), '')
    str = str.replace(new RegExp(",", "g"), '')
    if(str==''){
        str=0
    }
    return str
}

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

let _url = ""
function openModal(url){
    _url = btoa(url)
    window.history.pushState({}, document.title, `?ref_open=${_url}`);
    $('.modal-body').append("<div class='loader-ajax'></div>")
    $('#modal').modal('show')
        .find('.modal-body')
        .load(url, function(result, a){
            let isError = a=="error"
            if (isError) {
                $('#modal').modal('hide')
            }
        });
    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
}

function copyLink(e){
    let currentUrl = window.location.href
    $("#text_to_be_copied").text(`${currentUrl}?ref_open=${_url}`) //= _url
    CopyToClipboard(e, 'text_to_be_copied')
    $("#text_to_be_copied").text("")
}

function getTotalCount() {
    let elem = $("#totalCount")
    $.get(getUrl(), function(data, status){
        if (!isNaN(data)) {
            elem.text(data)
        }
    })
}
function getUrl(param) {
    param = param ? param : "scenario=get_count"
    if (window.location.search=="") {
        return "?"+param
    } else {
        return window.location.href +"&"+param
    }
}