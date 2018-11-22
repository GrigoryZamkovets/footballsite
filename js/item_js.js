function correctImage() {

    //correct height of image from football item
    var itemImage = document.querySelector('.football-item img');
    var imageStyle = getComputedStyle(itemImage);

    itemImage.style.height = imageStyle.width;

}

window.addEventListener("load", correctImage);

