$(document).ready(function() {

    // main-menu jquery

    // open menu by btn
    $('#menu-main .icon-menu').on('click', function () {
        $("#menu-main .icon-menu").css('opacity', '0.0');
        $("#menu-main .icon-menu").hide();
        $("#menu-main").animate({
            left: '0px'
        }, 200);
    });

    // close menu by close icon
    $('.icon-close-menu').click(function () {
        $("#menu-main").animate({
            left: '-255px'
        }, 200);
        $("#menu-main .icon-menu").show();
        $("#menu-main .icon-menu").animate({
            opacity: '1.0'
        }, 600);
    });

    // close menu by click on document
    $('body').bind('click', function(event) {
        if ('0px' === $('#menu-main').css('left')) {
            var target = $(event.target);
            var btnMenu = $('#menu-main .icon-menu');
            var mainMenu = $('#menu-main');
            if ( target.is("a") ) {
                target = target.parent();
            }
            if ( target.is("li") ) {
                target = target.parent();
            }
            target = target.parent();
            if (target.attr('id') != mainMenu.attr('id')) {
                $("#menu-main").animate({
                    left: '-255px'
                }, 200);
                $("#menu-main .icon-menu").show();
                $("#menu-main .icon-menu").animate({
                    opacity: '1.0'
                }, 600);
            }
        }
    });

    // button "to subscribe"
    $("#subscr-email").focus (function() {
        $( this ).removeClass('is-invalid');
        $('#subscr-email').val('');
    });

    $('#subscribe').click (function() {

       var email = $('#subscr-email').val();
       error = false;

       if(email.split('@').length == 1 || email.split('.').length == 1) {
           $('#subscr-email').addClass('is-invalid');
           $('#subscr-email').val('enter correct email!');

           error = true;
           return false;
       }

       if (error === false) {
           $.ajax({
               url: '/blocks/subscribe.php',
               type: 'POST',
               cache: false,
               dataType: 'html',
               data: { 'email': email },
               success: function(data) {
                   if ( data === "you are our new subscriber!" ) {
                       alert(data);
                       $('#subscr-email').addClass('.is-valid');
                   } else {
                       alert(data);
                       $('#subscr-email').addClass('is-invalid');
                   }
               }
           });
       }
    });

    // button "Search"
    $("#search-field").focus (function() {
        $( this ).removeClass('is-invalid');
        $('#search-field').val('');
    });

    $('#search').click (function() {
        var search = $('#search-field').val();
        search = search.trim();
        error = false;

        if(search == '') {
            $('#search-field').addClass('is-invalid');
            $('#search-field').val('enter search words!');

            error = true;
            return false;
        }

        if (error === false) {
            $.ajax({
                url: '/blocks/search_code.php',
                type: 'POST',
                cache: false,
                data: {'search': search},
                dataType: 'html',
                success: function(data) {
                    if ( data === 'enter correct search words!') {
                        $('#search-field').addClass('is-invalid');
                        $('#search-field').val('enter correct search words!');
                    } else {
                        window.location.href = data;
                    }
                }
            });
        }
    });

});

