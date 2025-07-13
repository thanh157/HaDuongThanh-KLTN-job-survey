$(document).ready(function () {
    console.log( "ready 123!" );
    $('#graduation_id').select2();
    SurveyController.loadDotTotNghiep();
});

var SurveyController = {
    loadDotTotNghiep() {
        $('#school_year').on('change', function () {
            const selectedYear = $(this).val();

            $('#graduation_id').empty();

            if (selectedYear) {
                $.ajax({
                    url: '/api/get-dot-tot-nghiep',  // Cập nhật route đúng theo backend
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { school_year: selectedYear },
                    success: function (data) {
                        console.log(data, '//datadata')
                        if (data.length > 0) {
                            data.forEach(function (item) {
                                $('#graduation_id').append(
                                    $('<option>', {
                                        value: item.id,
                                        text: item.name
                                    })
                                );
                            });
                        } else {
                            $('#graduation_id').append(
                                $('<option>', {
                                    disabled: true,
                                    text: 'Không có đợt tốt nghiệp nào trong năm này'
                                })
                            );
                        }
                    },
                    error: function () {
                        alert('Lỗi khi tải danh sách đợt tốt nghiệp');
                    }
                });
            }
        });
    }
}
