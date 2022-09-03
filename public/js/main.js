$(document).ready(function(){
    $('.modalInfoShow').on('click', function (e) {
        e.preventDefault()
        $('#modalInfoTitle').text($(this).parent().parent().siblings('.panel-heading').find('.panel-title').text())
        var id = $(this).parent().parent().parent().parent().data('id')
        $.ajax({
            url: '/event/' + id,
            success: function (e) {
                console.log(e)
                $('#fullDescription').text(e.description)
            }
        })
    })

    $('#clientForm').on('submit', function (e) {
        e.preventDefault()

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data)
            {
                alert(data);
            }
        });
    })
});