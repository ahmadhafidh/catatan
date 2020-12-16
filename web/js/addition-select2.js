$(document).ready(function () {
    $('.select2').each(function () {
        var plc = $(this).find('option:eq(0)').text()
        console.log(plc)
        $(this).select2({
            placeholder: plc,
            allowClear: true,
            dropdownAutoWidth: true,
            width: "100%"
        });
    });
    $('.select2multi').each(function () {
        $(this).select2({
            placeholder: "Select",
            allowClear: true,
            dropdownAutoWidth: true,
            width: "100%"
        });
    });

    $('#menu-data-icon').select2({
        // allowClear: true,
        // formatResult: formatResult,
        // formatSelection: formatli,
        width: "100%",
        templateResult: formatTemplate,
        templateSelection: formatTemplate
    });

    $('#menu-parent_name').select2({
        width: "100%"
    });
    $('#menu-route').select2({
        width: "100%"
    });

    // show icon on create menu
    function formatTemplate(icon) {
        if (!icon.id) {
            return icon.text;
        }
        var state = $(
            "<span><i class='" + icon.element.value.toLowerCase() + "' /> " + icon.text + "</span>"
        );
        return state;
    }

});