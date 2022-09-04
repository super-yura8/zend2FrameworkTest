$(document).ready(function(){
    $('.modalInfoShow').on('click', function (e) {
        e.preventDefault();
        var id = $(this).parent().parent().parent().parent().data('id');
        $('#modalInfoTitle').text($(this).parent().parent().siblings('.panel-heading').find('.panel-title').text());       $('#modalInfoTitle').text($(this).parent().parent().siblings('.panel-heading').find('.panel-title').text())
        $('#client input[name="event"]').val(id);

        $.ajax({
            url: '/events/' + id,
            success: function (e) {
                $('#fullDescription').text(e.description)
            }
        })
    })
});