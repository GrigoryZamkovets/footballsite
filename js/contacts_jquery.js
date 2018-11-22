
// connect tooltips
$('[data-toggle="tooltip"]').tooltip();


// work with button "send message"
$(".contacts-info input").focus(function() {
    $( this ).val('');
    $( this ).removeClass('is-invalid');
    $('.success-feedback').remove();
    $('.error-feedback').remove();
});
$(".contacts-info textarea").focus(function() {
    $( this ).val('');
    $( this ).removeClass('is-invalid');
    $('.success-feedback').remove();
    $('.error-feedback').remove();
});

$('#send').click (function() {
    $('.success-feedback').remove();
    $('.error-feedback').remove();

    $('#name').removeClass('is-invalid');
    $('#email').removeClass('is-invalid');
    $('#subject').removeClass('is-invalid');
    $('#message').removeClass('is-invalid');

    var name = $('#name').val();
    var email = $('#email').val();
    var subject = $('#subject').val();
    var message = $('#message').val();
    var error = false;

    if (name == "") {
        $('#name').addClass('is-invalid');
        $('#name').val('enter your name!');

        error = true;
        return false;
    }
    if(email.split('@').length == 1 || email.split('.').length == 1) {
        $('#email').addClass('is-invalid');
        $('#email').val('enter correct email!');

        error = true;
        return false;
    }
    if(subject.length == 0) {
        $('#subject').addClass('is-invalid');
        $('#subject').val('enter subject of the email!');

        error = true;
        return false;
    }
    if(message.length == 0) {
        $('#message').addClass('is-invalid');
        $('#message').val('enter your message!');

        error = true;
        return false;
    }

    if (error === false) {
        $.ajax({
            url: '/blocks/feedback.php',
            type: 'POST',
            cache: false,
            data: {'name': name, 'email': email, 'subject': subject, 'message': message},
            dataType: 'html',
            success: function(data) {
                if (data === 'your message has been sent!') {
                    var divMess = $('<div class="success-feedback"></div>');
                } else {
                    var divMess = $('<div class="error-feedback"></div>');
                }
                divMess.text(data);
                $(divMess).insertAfter('.contacts-info form');
            }
        });
    }

});






