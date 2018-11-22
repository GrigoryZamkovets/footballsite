
// code with vue framework
new Vue ({
    el: '#app-authorization-form',
    data: {
        show: false
    },
    methods: {
        changePassword() {
            this.show = !this.show
            document.getElementById('password').value = ''
            document.getElementById('password1').value = ''
            document.getElementById('password2').value = ''
            if (this.show === true) {
                document.getElementById('app-authorization-form').password.disabled = true
            } else {
                document.getElementById('app-authorization-form').password.disabled = false
            }
        }
    }
});

// work with button "enter admin"
$(".authorization-form input").focus(function() {
    $( this ).removeClass('is-invalid');
    $('.success-form').remove();
    $('.error-form').remove();
});

$('#send').click (function() {
    $('.success-form').remove();
    $('.error-form').remove();

    $('#username').removeClass('is-invalid');
    $('#password').removeClass('is-invalid');
    $('#password1').removeClass('is-invalid');
    $('#password2').removeClass('is-invalid');

    var username = $('#username').val();
    var password = $('#password').val();
    var password1 = $('#password1').val();
    var password2 = $('#password2').val();
    var error = false;

    if (username == "") {
        $('#username').addClass('is-invalid');
        var divMess = $('<div class="error-form"></div>');
        divMess.text('enter your username!');
        $(divMess).insertAfter('#app-authorization-form');

        error = true;
        return false;
    }

    if( (password === '') && (document.getElementById('app-authorization-form').password.disabled === false) ) {
        $('#password').addClass('is-invalid');
        var divMess = $('<div class="error-form"></div>');
        divMess.text('enter your password!');
        $(divMess).insertAfter('#app-authorization-form');

        error = true;
        return false;
    }

    if( (password1 === '') && (document.getElementById('app-authorization-form').password.disabled === true) ) {
        $('#password1').addClass('is-invalid');
        var divMess = $('<div class="error-form"></div>');
        divMess.text('enter your new password!');
        $(divMess).insertAfter('#app-authorization-form');

        error = true;
        return false;
    }

    if( (password2 === '') && (document.getElementById('app-authorization-form').password.disabled === true) ) {
        $('#password2').addClass('is-invalid');
        var divMess = $('<div class="error-form"></div>');
        divMess.text('repeat your new password!');
        $(divMess).insertAfter('#app-authorization-form');

        error = true;
        return false;
    }

    if( (password1 !== password2) &&
        (document.getElementById('app-authorization-form').password.disabled === true) ) {

        $('#password2').addClass('is-invalid');
        var divMess = $('<div class="error-form"></div>');
        divMess.text('your passwords do not match!');
        $(divMess).insertAfter('#app-authorization-form');

        error = true;
        return false;
    }

    if (error === false) {
        $.ajax({
            url: '/blocks/authorization_code.php',
            type: 'POST',
            cache: false,
            data: {'username': username, 'password': password, 'password1': password1, 'password2': password2},
            dataType: 'html',
            success: function(data) {
                switch (data) {
                    case 'correct username and password':
                        window.location.href = "/pages/admin.php";
                        break;
                    case 'your password was updated successfully!':
                        var divMess = $('<div class="success-form"></div>');
                        divMess.text(data);
                        $(divMess).insertAfter('#app-authorization-form');
                        break;
                    default:
                        var divMess = $('<div class="error-form"></div>');
                        divMess.text(data);
                        $(divMess).insertAfter('#app-authorization-form');
                }
            }
        });
    }

});

