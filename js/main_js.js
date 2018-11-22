window.addEventListener("load", function() {

    // modal image javascript
    var advertizingImages = document.getElementsByClassName('modal-js-advertizing');
    var modalWindow = document.getElementById('modal-js-id');
    var modalImg = document.getElementById('modal-js-img');
    var modalContent = document.getElementById('modal-js-content');
    var i;

    for (i = 0; i < advertizingImages.length; i++) {
        advertizingImages[i].onclick = function () {
            var img = this.getElementsByTagName('img')[0];
            modalWindow.style.display = 'block';
            modalImg.src = img.src;
            var content = this.getElementsByClassName('modal-js-content')[0];
            modalContent.innerHTML = content.innerHTML;
        }
    }

});

