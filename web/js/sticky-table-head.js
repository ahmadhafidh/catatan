// Sticky header tbl

$(document).ready(function () {
    const table = $(".scrollable").first().clone()
    table.removeClass("collapse-tr")
    const refId = $(".grid-view").first().attr("id")
    table.attr("id", "cad")
    // $("#"+refId).find(".select2Cad").select2({
    //     width: "100%"
    // })
    $("#"+refId).find(".select2Cad").select2({
        width: "100%"
    })
    table.find("table").find("tbody").remove()
    $("#"+refId).on("input", "input", function(e){
        table.find("input[name='"+$(this).attr("name")+"']").val($(this).val())        
    })
    $("#"+refId).on("change", "input", function(e){
        table.find("input[name='"+$(this).attr("name")+"']").val($(this).val())        
    })
    table.on("input", "input", function(e){
        $("#"+refId).find("input[name='"+$(this).attr("name")+"']").val($(this).val())        
    })
    table.on("change", "select", function(e){
        
        $("#"+refId).find("select[name='"+$(this).attr("name")+"']").val($(this).val())        
    })
    let thead = table.prependTo($(document.body));
    // $("#cad").find(".select2").select2()
    thead.hide().css({
        overflowX: 'hidden',
        overflowY: 'visible',
        position: 'fixed',
        zIndex: 998,
        height: 100,
        width: '100%',
        top: $(".navbar").outerHeight(),
        marginBottom: 0,
    });
    let fakecontent = thead.find('div');

    function top(e) {
        return e.offset().top;
    }

    function bottom(e) {
        return e.offset().top + e.height();
    }

    let active = $([]);

    function find_active() {
        thead.show();
        let active = $([]);
        $('.scrollable').each(function () {
            if (top($(this)) < top(thead) && bottom($(this)) > bottom(thead)) {
                fakecontent.width($(this).get(0).scrollWidth);
                fakecontent.height(1);
                active = $(this);
            }
        });
        fit(active);
        return active;
    }

    function fit(active) {
        if (!active.length) return thead.hide();
        thead.css({
            left: active.offset().left,
            width: active.width()
        });
        fakecontent.width($(this).get(0).scrollWidth);
        fakecontent.height(1);
        delete lastScroll;
    }

    function onscroll() {
        let oldactive = active;
        active = find_active();
        if (oldactive.not(active).length) {
            oldactive.unbind('scroll', update);
            table.find(".select2Cad").select2("destroy")
            const picker = $(".picker").clone()
            // $(".picker").show()
            doPickadate()
            $("#"+refId).find(".select2Cad").select2({
                width: "100%"
            })
            $("select").parents("td").css({
                width: 250
            })
            
        }
        if (active.not(oldactive).length) {
            $("#"+refId).find(".select2Cad").select2("destroy")
            const picker = $(".picker").clone()
            doPickadate()
            table.find(".select2Cad").select2({
                width: "100%"
            })
            // $(".picker").hide()
            // picker.prependTo("body")
            active.scroll(update);
        }
        update();
    }

    let lastScroll;

    function scroll() {
        if (!active.length) return;
        if (thead.scrollLeft() === lastScroll) return;
        lastScroll = thead.scrollLeft();
        active.scrollLeft(lastScroll);
    }

    function update() {
        if (!active.length) return;
        if (active.scrollLeft() === lastScroll) return;
        lastScroll = active.scrollLeft();
        thead.scrollLeft(lastScroll);
    }

    thead.scroll(scroll);

    onscroll();
    $(window).scroll(onscroll);
    $(window).resize(onscroll);
})

function doPickadate() {
    $('.pickadate').pickadate({
        labelMonthNext: 'Next month',
        format: 'yyyy-mm-dd',
        labelMonthPrev: 'Previous month',
        labelMonthSelect: 'Pick a Month',
        labelYearSelect: 'Pick a Year',
        selectMonths: true,
        selectYears: true,
    });
    
    $(".pickadate").change(function(e){
        $("thead").find("input[name='"+$(this).attr("name")+"']").val($(this).val())  
    })
}