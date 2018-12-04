const current = document.querySelector('#current');
const images = document.querySelectorAll('.images img');
const opacity = 0.5;

//Set first #current image to have the opacity.
images[0].style.opacity = 0.5;

images.forEach(img =>
    img.addEventListener('click', imageClicked)
    );
function imageClicked(e){
    //Reset opacity of images(to avoid setting all opacitys to faded).
    images.forEach(img => img.style.opacity = 1);

    //Sets the #current images source to the source of the image that was clicked.
    current.src = e.target.src;

    //Add fadeIn class to the #current image.
    current.classList.add('fade-in');

    //Remove the fade-in class after it is clicked.
    setTimeout(() => current.classList.remove('fade-in'), 500);

    //Sets the opacity to the constant
    e.target.style.opacity = opacity;
}
console.log("wittue mitae paskaa");
