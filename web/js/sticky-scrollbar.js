$('document').ready(function(){    
    
    // Tabel Floating Scrollbar
    let scrollbar = $('<div id=""><div></div></div>').appendTo($(document.body));
    scrollbar.hide().css({
        overflowX: 'auto',
        position: 'fixed',
        zIndex: 998,
        width: '100%',
        bottom: 0
    });
    let fakecontent = scrollbar.find('div');

    function top(e) {
        return e.offset().top;
    }

    function bottom(e) {
        return e.offset().top + e.height();
    }

    let active = $([]);

    function find_active() {
        scrollbar.show();
        let active = $([]);
        $('.scrollable').each(function () {
            if (top($(this)) < top(scrollbar) && bottom($(this)) > bottom(scrollbar)) {
                fakecontent.width($(this).get(0).scrollWidth);
                fakecontent.height(1);
                active = $(this);
            }
        });
        fit(active);
        return active;
    }

    function fit(active) {
        if (!active.length) return scrollbar.hide();
        scrollbar.css({
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
        }
        if (active.not(oldactive).length) {
            active.scroll(update);
        }
        update();
    }

    let lastScroll;

    function scroll() {
        if (!active.length) return;
        if (scrollbar.scrollLeft() === lastScroll) return;
        lastScroll = scrollbar.scrollLeft();
        active.scrollLeft(lastScroll);
    }
    function update() {
        if (!active.length) return;
        if (active.scrollLeft() === lastScroll) return;
        lastScroll = active.scrollLeft();
        scrollbar.scrollLeft(lastScroll);
    }

    scrollbar.scroll(scroll);

    onscroll();
    $(window).scroll(onscroll);
    $(window).resize(onscroll);
    
})
