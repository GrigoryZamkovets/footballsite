//update label for file-input
var img_file = false;

function labelValue(value, file) {
    var labelElement = document.getElementsByClassName('custom-file-label')[0];
    labelElement.innerHTML = value;

    if (labelElement.innerHTML == '') {
        labelElement.innerHTML = "choose image for this article";
        img_file = false;
    } else {
        labelElement.innerHTML = file.name;
        img_file = file;
    }
}

// code with vue framework
new Vue ({
    el: '#app-admin-form',
    data: {
        show: true,

        // we get this variable from php
        categories: categories,
    },
    methods: {
        checkCategory() {
            this.show = !this.show

            var selects = document.querySelectorAll('.custom-select')
            for (var i = 0; i < selects.length; i++) {
                selects[i].options.selectedIndex = 0
            }

            document.querySelector('#headline-admin-form').value = ''
            document.querySelector('#article-admin-form').value = ''
            document.querySelector('#news-admin-form').value = ''

            document.querySelector('#uploadImage').value = ''
            var labelElement = document.getElementsByClassName('custom-file-label')[0]
            labelElement.innerHTML = 'choose image to this article'

            var subscribeCheckbox = document.querySelector('#subscribe-checkbox')
            subscribeCheckbox.checked = false;
        }
    },
    computed: {
        categoriesArticles() {
            var cat = []
            var j = 0
            for (var i = 0; i < this.categories.length; i++) {
                if (this.categories[i]['id_subcategory'] == 13
                || this.categories[i]['id_subcategory'] == 15) continue
                cat[j] = []
                cat[j] = this.categories[i]
                j++
            }
            return cat
        },
        categoriesNews() {
            var cat = []
            var j = 0
            for (var i = 0; i < this.categories.length; i++) {
                if (this.categories[i]['id_subcategory'] == 15) continue
                cat[j] = []
                cat[j] = this.categories[i]
                j++
            }
            return cat
        }
    },
    filters: {
        lowercase(value) {
            return value.toLowerCase()
        }
    }
});

// work with button "enter admin"
$("#app-admin-form textarea").focus(function() {
    $( this ).removeClass('is-invalid');
    $('.success-form').remove();
    $('.error-form').remove();
});

$("#app-admin-form select").focus(function() {
    $( this ).removeClass('is-invalid');
    $('.success-form').remove();
    $('.error-form').remove();
});

$("#app-admin-form input").focus(function() {
    $( this ).removeClass('is-invalid');
    $('.success-form').remove();
    $('.error-form').remove();
});

$('#publish').click (function() {
    $('.success-form').remove();
    $('.error-form').remove();

    if ( document.getElementById('footballArticle').checked ) {
        $('#select-id-article').removeClass('is-invalid');
        $('#headline-admin-form').removeClass('is-invalid');
        $('#article-admin-form').removeClass('is-invalid');

        var purpose = 'article';
        var selectCat = $('#select-id-article').val();
        var title = $('#headline-admin-form').val();
        var text = $('#article-admin-form').val();
        var error = false;

        if (selectCat == 0) {
            $('#select-id-article').addClass('is-invalid');
            var divMess = $('<div class="error-form"></div>');
            divMess.text('select category of your article!');
            $(divMess).insertAfter('#app-admin-form');

            error = true;
            return false;
        }

        if (title == "") {
            $('#headline-admin-form').addClass('is-invalid');
            var divMess = $('<div class="error-form"></div>');
            divMess.text('enter headline of your article!');
            $(divMess).insertAfter('#app-admin-form');

            error = true;
            return false;
        }

        if (text == "") {
            $('#article-admin-form').addClass('is-invalid');
            var divMess = $('<div class="error-form"></div>');
            divMess.text('enter content of your article!');
            $(divMess).insertAfter('#app-admin-form');

            error = true;
            return false;
        }

        if ( img_file !== false ) {
            var type_file = img_file.name.split(".");
            if (type_file[type_file.length-1] !== 'jpg' &&
                type_file[type_file.length-1] !== 'jpeg' &&
                type_file[type_file.length-1] !== 'JPG' &&
                type_file[type_file.length-1] !== 'JPEG')
            {
                $('#uploadImage').addClass('is-invalid');
                var divMess = $('<div class="error-form"></div>');
                divMess.text('enter correct image for your article!');
                $(divMess).insertAfter('#app-admin-form');
            }
        }


        if (error === false) {
            var fd = new FormData();
            fd.append( 'purpose', purpose );
            fd.append( 'selectCat', selectCat );
            fd.append( 'title', title );
            fd.append( 'text', text );
            fd.append( 'img_file', img_file );

            $.ajax({
                url: '/blocks/publish.php',
                type: 'POST',
                processData: false,
                contentType: false,
                data: fd,
                success: function(data) {
                    if (data === 'your article has been published!') {
                        var divMess = $('<div class="success-form"></div>');

                        document.querySelector('#select-id-article').options.selectedIndex = 0;
                        document.querySelector('#headline-admin-form').value = '';
                        document.querySelector('#article-admin-form').value = '';
                        document.querySelector('#uploadImage').value = '';
                        document.getElementsByClassName('custom-file-label')[0].
                                                                    innerHTML = 'choose image to this article';
                    } else {
                        var divMess = $('<div class="error-form"></div>');
                    }
                    divMess.text(data);
                    $(divMess).insertAfter('#app-admin-form');
                }
            });
        }

    }

    if ( document.getElementById('footballNews').checked ) {
        $('#select-id-news').removeClass('is-invalid');
        $('#news-admin-form').removeClass('is-invalid');

        var purpose = 'news';
        var selectCat = $('#select-id-news').val();
        var text = $('#news-admin-form').val();
        var email_bool = document.getElementById('subscribe-checkbox').checked;
        var error = false;

        if (selectCat == 0) {
            $('#select-id-news').addClass('is-invalid');
            var divMess = $('<div class="error-form"></div>');
            divMess.text('select category of your news item!');
            $(divMess).insertAfter('#app-admin-form');

            error = true;
            return false;
        }

        if (text == "") {
            $('#news-admin-form').addClass('is-invalid');
            var divMess = $('<div class="error-form"></div>');
            divMess.text('enter content of your news item!');
            $(divMess).insertAfter('#app-admin-form');

            error = true;
            return false;
        }

        if (error === false) {
            $.ajax({
                url: '/blocks/publish.php',
                type: 'POST',
                cache: false,
                data: {'purpose': purpose, 'selectCat': selectCat, 'text': text, 'email_bool': email_bool},
                dataType: 'html',
                success: function(data) {
                    if (data === 'your news item has been published!' ||
                        data === 'your news item has been published and has been sent to subscribers!' ||
                        data === 'your news item has been published but has been not sent to subscribers!'
                    ) {
                        var divMess = $('<div class="success-form"></div>');

                        document.querySelector('#select-id-news').options.selectedIndex = 0;
                        document.querySelector('#news-admin-form').value = '';
                    } else {
                        var divMess = $('<div class="error-form"></div>');
                    }
                    divMess.text(data);
                    $(divMess).insertAfter('#app-admin-form');
                }
            });
        }
    }
});

