	// imagenes
let slideImages = document.querySelectorAll('img');
// botones
let next = document.querySelector('.next');
let prev = document.querySelector('.prev');
// indicador
let dots = document.querySelectorAll('.dot');

var counter = 0;

// button next
next.addEventListener('click', slideNext);
function slideNext(){
slideImages[counter].style.animation = 'next1 0.3s ease-in forwards';
if(counter >= slideImages.length-1){
  counter = 0;
}
else{
  counter++;
}
slideImages[counter].style.animation = 'next2 0.3s ease-in forwards';
indicators();
}

// button prev
prev.addEventListener('click', slidePrev);
function slidePrev(){
slideImages[counter].style.animation = 'prev1 0.3s ease-in forwards';
if(counter == 0){
  counter = slideImages.length-1;
}
else{
  counter--;
}
slideImages[counter].style.animation = 'prev2 0.3s ease-in forwards';
indicators();
}

// carrusel automatico
function autoSliding(){
  deletInterval = setInterval(timer, 3000);
  function timer(){
    slideNext();
    indicators();
  }
}
autoSliding();

// mouse este encima, el carrusel sedetenga
const container = document.querySelector('.slide-container');
container.addEventListener('mouseover', function(){
  clearInterval(deletInterval);
});

// se llama la funcion de pare y siga
container.addEventListener('mouseout', autoSliding);

// la funcion de los indicadores
function indicators(){
  for(i = 0; i < dots.length; i++){
    dots[i].className = dots[i].className.replace(' active', '');
  }
  dots[counter].className += ' active';
}

// funcion al dar click en los indicadores
function switchImage(currentImage){
  currentImage.classList.add('active');
  var imageId = currentImage.getAttribute('attr');
  if(imageId > counter){
  slideImages[counter].style.animation = 'next1 0.3s ease-in forwards';
  counter = imageId;
  slideImages[counter].style.animation = 'next2 0.3s ease-in forwards';
  }
  else if(imageId == counter){
    return;
  }
  else{
  slideImages[counter].style.animation = 'prev1 0.3s ease-in forwards';
  counter = imageId;
  slideImages[counter].style.animation = 'prev2 0.3s ease-in forwards';	
  }
  indicators();
}



const hamburgerMenu = document.getElementById("hamburger-menu");
const navLinks = document.getElementById("nav-links");
const des = document.getElementById("carousel-navigation");

hamburgerMenu.addEventListener("click", () => {
  navLinks.classList.toggle("active");
});

// Agregar un evento de clic a cada enlace del menú para ocultar el menú
const menuLinks = document.querySelectorAll(".nav-links a");

menuLinks.forEach(link => {
  link.addEventListener("click", () => {
    navLinks.classList.remove("active");
    
  });
});


