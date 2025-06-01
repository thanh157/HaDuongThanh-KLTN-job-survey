$(document).ready(function () {
    Noty.overrideDefaults({
        theme: 'limitless',
        layout: 'topRight',
        type: 'alert',
        timeout: 2500
    });

    const optionLocales = {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Chọn",
        "cancelLabel": "Đóng",
        "fromLabel": "Từ",
        "toLabel": "Đến",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "CN",
            "T2",
            "T3",
            "T4",
            "T5",
            "T6",
            "T7"
        ],
        "monthNames": [
            "Tháng 1",
            "Tháng 2",
            "Tháng 3",
            "Tháng 4",
            "Tháng 5",
            "Tháng 6",
            "Tháng 7",
            "Tháng 8",
            "Tháng 9",
            "Tháng 10",
            "Tháng 11",
            "Tháng 12",
        ],
        "firstDay": 1
    }


    $('.money').simpleMoneyFormat()

    $('.daterange-single').daterangepicker({
        parentEl: '.content-inner',
        singleDatePicker: true,
        locale: optionLocales
    });
})

const swalInit = swal.mixin({
    buttonsStyling: false,
    customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-light',
        denyButton: 'btn btn-light',
        input: 'form-control'
    }
});

const init = {
    showNotySuccess: (message) => {
        new Noty({
            text: message,
            type: 'success',
            closeWith: ['button']
        }).show();
    },

    showNotyError: (message) => {
        new Noty({
            text: message,
            type: 'error',
            closeWith: ['button']
        }).show();
    }
}

const options = {
    filebrowserImageBrowseUrl: '/filemanager?type=Images',
    filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/filemanager?type=Files',
    filebrowserUploadUrl: '/filemanager/upload?type=Files&_token=',
    language: 'vi'
}

