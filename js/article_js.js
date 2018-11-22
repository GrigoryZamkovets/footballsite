function correctImage() {

    //correct height of image from football article
    var articleImage = document.querySelector('.football-article img');
    var screenWidth = document.documentElement.clientWidth;

    var imgStyle2 = getComputedStyle(articleImage);
    if ((imgStyle2.width < imgStyle2.height) && screenWidth >= 1500) {
        articleImage.style.height = '280px';
        articleImage.style.width = 'auto';
    }
    if ((imgStyle2.width < imgStyle2.height) && (screenWidth >= 992 && screenWidth < 1200)) {
        articleImage.style.height = '220px';
        articleImage.style.width = 'auto';
    }

}

window.addEventListener("load", correctImage);

