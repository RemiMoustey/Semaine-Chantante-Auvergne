/*
	Cette classe met en place le diaporama présent en haut de la page
*/

class Carousel {

	// Crée l'objet et met à disposition le tableau des slides
	constructor(element) {
		this.element = element;
		this.element.classList.add("carousel");
		this.slides = this.createDivWithClass("slides");
		this.container = this.createDivWithClass("carousel_container");
		this.slides.appendChild(this.container);
		document.getElementById("bloc_page").appendChild(this.element);
		this.images = [this.getImage("./public/img/1-r.png", "Volcans du département du Puy-de-Dôme", "image-1"),
		this.getImage("./public/img/2-r.png", "Image de choristes", "image-2")];
		this.animationId = null;
		this.createNavigation();
	}

	/*
		Met en place les animations du diaporama en appelant la fonction nécessaire
	*/
	createNavigation () {
		let callNext = this.determineNewItem.bind(this);
		setInterval(callNext, 5000);
	}

	/*
		Sélectionne le slide suivant
	*/
	determineNewItem() {
		if(document.querySelector("img").classList.contains("image-1")) {
			this.newItem(1);
			/* this.animationNewItem(); */
			return;
		}
		else if(document.querySelector("img").classList.contains("image-2")) {
			this.newItem(0);
			/* this.animationNewItem(); */
			return;
		}
	}

	// Sélectionne (grâce au tableau this.images) et crée le nouveau slide après un changement automatique ou par l'utilisateur.
	newItem(range) {
		let image = document.createElement("img");
		image.setAttribute("src", this.images[range].src);
		image.setAttribute("alt", this.images[range].alt);
		image.classList.add(this.images[range].classHTML);
		let classImage = '';
		if (document.querySelector('img').classList[0] === 'image-1')
		{
			classImage = '.image-1';
		}
		else
		{
			classImage = '.image-2';
		}
		document.querySelector("#carousel_item").replaceChild(image, document.querySelector(classImage));
	}

	// Définit l'animation du nouveau slide jusqu'à son arrêt.
	/* animationNewItem() {
		let xItem = parseFloat(getComputedStyle(document.querySelector("img")).left);
		let vitesse = 70;
		document.querySelector("img").style.left = xItem + vitesse + "px";
		if(xItem > 70) {
			this.animationId = requestAnimationFrame(this.nextNew.bind(this));
		} else {
			cancelAnimationFrame(this.animationId);
			document.querySelector("img").classList.remove("new_carousel_item");
		}
	}
 */
	getImage(src, alt, classHTML) {
		return new Image(src, alt, classHTML);
	}

	createDivWithClass(className) {
		let div = document.createElement("div");
		div.classList.add(className);
		return div;
	}
}

// L'événement DOMContentLoaded permet de ne créer le diaporama qu'une fois que le document HTML a été entièrement chargé.
document.addEventListener('DOMContentLoaded', function() {
	new Carousel(document.createElement("div"));
});