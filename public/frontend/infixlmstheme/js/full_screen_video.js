$(document).ready(function () {
    var base_url = $('.base_url').val();
    var csrf = $('.csrf_token').val();

    $(document).on('click', '.course_name', function (e) {

        let status = 0;
        if ($(this).prop('checked') == true)
            status = 1;
        let course_id = $(this).data('course');
        let lesson_id = $(this).data('lesson');
        $.ajax({
            url: base_url + '/lesson-complete',
            method: 'POST',
            data: {
                status: status,
                course_id: course_id,
                lesson_id: lesson_id,
                _token: csrf,
            },

            success: function (result) {
                location.reload();
                $('.certificate_btn').hide();

                if (result.btn == 1) {
                    $('.certificate').show();
                } else {
                    $('.certificate').hide();
                }
            }
        })

    })

    $(document).on('click', '#QuestionSubmit', function (e) {
        let course_id = $('#qa_course_id').val();
        let lesson_id = $('#qa_lesson_id').val();
        let editor =$('#qna_editor');

        let qna_editor = editor.val();
        // if (qna_editor == "") {
        //     toastr.warning($('#plz_write_qus').val());
        //     return false;
        // }


        if (editor.summernote('isEmpty')) {
            toastr.warning($('#plz_write_qus').val());
            return false;
        }

        let btn = $(this);
        btn.hide();
        // $('#qnamodal').modal('hide');
        $.ajax({
            url: $('#qaStoreID').val(),
            method: 'POST',
            data: {
                course_id: course_id,
                lesson_id: lesson_id,
                text: qna_editor,
                _token: csrf,
            },

            success: function (result) {
                toastr.success($('#operation_success').val(), $('#success_msg').val());
                btn.show();
                editor.summernote('reset');
            },
            error: function () {
                toastr.error("Something Went Wrong", 'Error');
                $('#qnamodal').modal('show');
                btn.show();
            }
        })

    })

});

function goFullScreen(course_id, lesson_id) {
    var url = document.getElementById('url').value;
    window.location.assign(url + '/fullscreen-view/' + course_id + '/' + lesson_id);

}

function goQuizTest(current) {
    // let link = current.('url');
    window.location.href = current;
}


/* MUPO premium lesson workspace - front-end interaction only. */
$(document).ready(function () {
    var $focusToggle = $('#mupoFocusToggle');

    $focusToggle.on('click', function () {
        $('body').toggleClass('mupo-focus-mode');
        var active = $('body').hasClass('mupo-focus-mode');

        $(this)
            .toggleClass('is-active', active)
            .attr('aria-pressed', active ? 'true' : 'false')
            .attr('title', active ? 'Show Course Content' : 'Focus Mode');

        $(this).find('i')
            .toggleClass('fa-expand-alt', !active)
            .toggleClass('fa-compress-alt', active);

        $(this).find('span').text(active ? 'Contents' : 'Focus');
    });

    // Keep the currently selected lesson visible in long course outlines.
    var $activeLesson = $('.course__play_list .single_play_list > a.active').first();
    if ($activeLesson.length) {
        var $scrollArea = $('.course__play_list');
        var targetTop = $activeLesson.position().top + $scrollArea.scrollTop() - 90;
        $scrollArea.scrollTop(Math.max(0, targetTop));
    }
});

