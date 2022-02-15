$(document).ready(function () {
    let storage = window.localStorage;
    //form page view/create/update option
    let optionVal = storage.getItem("ckOption");
    if (optionVal) {
        $('input[name="ckOption"][value="' + optionVal + '"]').prop('checked', true);
    }

    $(".ckMark").click(function() {
        if ($(this).is(':checked')) {
            $(".ckMark").prop("checked", false);
            $(this).prop("checked", true);
            storage.setItem('ckOption', $(this).val());
        }
    });

    //sidebar toggle
    let collapse_val = storage.getItem("sidebar-collapse");
    if (collapse_val === '1') {
        $('body').addClass('sidebar-collapse');
    } else {
        $('body').removeClass('sidebar-collapse');
    }

    $('.sidebar-toggle').on('click', function(){
        if (!$('body').hasClass('sidebar-collapse')) {
            storage.setItem('sidebar-collapse', '1');
        } else {
            storage.setItem('sidebar-collapse', '0');
        }
    });
});