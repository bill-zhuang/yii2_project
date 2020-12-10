$(document).ready(function () {
    let storage = window.localStorage;
    let value = storage.getItem("ckOption");
    if (value) {
        $('input[name="ckOption"][value="' + value + '"]').prop('checked', true);
    }

    $(".ckMark").click(function() {
        if ($(this).is(':checked')) {
            $(".ckMark").prop("checked", false);
            $(this).prop("checked", true);
            storage.setItem('ckOption', $(this).val());
        }
    });
});