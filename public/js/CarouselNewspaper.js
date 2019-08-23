 /*
	Cette classe met en place le diaporama présent en haut de la page.
*/

class CarouselNewspaper {

	// Crée l'objet et ses conteneurs et met à disposition le tableau des slides. 
	constructor() {
		this.slides = this.createDivWithClass("slides");
        this.container = this.createDivWithClass("carousel_container");
        this.container.appendChild(document.querySelector('.carousel_image'));
		this.slides.appendChild(this.container);
		this.images = [this.getImage("./public/img/presse/001.png", "Lion à vélo sur photo de Lyon", "image_1"),
		this.getImage("./public/img/presse/002.png", "Pan de la carte du site et petit cartouche d'explication", "image_2"),
		this.getImage("./public/img/presse/003.png", "Formulaire à côté de la carte avec les champs 'Nom' et 'Prénom'", "image_3"),
		this.getImage("./public/img/presse/004.png", "Le champ de signature sous le formulaire", "image_4"),
        this.getImage("./public/img/presse/009.png", "Compteur de 20 minutes qui symbolise le temps de la réservation", "image_5")];
		this.animationId = null;
		this.animationStop = true;
		this.createNavigation();
	}

	/*
		- Met en place les boutons permettant de naviguer dans le diaporama.
		- Écoute les événements issus de l'interaction de l'utilisateur avec le programme
		(clics sur les boutons, changements de slide avec le clavier).
		- Appelle les fonctions nécessaires au fonctionnement des animations.
	*/
	createNavigation () {
		let prevArrow = this.createDivWithClass("carousel_prev");
        let nextArrow = this.createDivWithClass("carousel_next");
        let buttons = this.createDivWithClass("buttons");
		prevArrow.classList.add("fas");
        prevArrow.classList.add("fa-chevron-left");
		nextArrow.classList.add("fas");
        nextArrow.classList.add("fa-chevron-right");
        buttons.appendChild(prevArrow);
        buttons.appendChild(nextArrow);
        this.slides.appendChild(buttons);
		$('.carousel').append(this.slides);
		let callNext = this.next.bind(this);
        let callPrev = this.prev.bind(this);
		nextArrow.addEventListener("click", function() {
            callNext();
        });
        prevArrow.addEventListener("click", function() {
            callPrev();
        });

		document.addEventListener("keydown", function (e) {
			if(e.keyCode === 37) {
                callPrev();
			}
			else if(e.keyCode === 39) {
                callNext();
			}
		});
	}

	/*
	Les deux méthodes suivantes préviennent qu'une animation est en cours et appellent
	la méthode permettant l'apparition et le glissement du nouvel élément. 
	Ainsi, aucune animation ne peut être déclenchée si une autre animation est en cours.
	*/
	prev() {
		if(this.animationStop === true) {
			this.animationStop = false;
			this.determinePrevNewItem();
		}
	}

	next() {
		if(this.animationStop === true) {
			this.animationStop = false;
			this.determineNextNewItem();
		}
	}

	/*
		Les deux méthodes suivantes appellent les méthodes :
		- qui sélectionnent le slide suivant
		- qui déterminent la direction du slide suivant selon qu'il s'agit du précédent ou du suivant.
	*/
	determinePrevNewItem() {
		if(document.querySelector("img").classList.contains("image_1")) {
			this.newItem(4);
			this.prevNew();
			return;
		}
		for(let i = 1; i < this.images.length; i++) {
			if(document.querySelector("img").classList[0] === this.images[i].classHTML) {
				this.newItem(i - 1);
				this.prevNew();
				return;
			}
		}
	}

	determineNextNewItem() {
		if(document.querySelector("img").classList.contains("image_5")) {
			this.newItem(0);
			this.nextNew();
			return;
		}
		for(let i = 0; i < this.images.length - 1; i++) {
			if(document.querySelector("img").classList[0] === this.images[i].classHTML) {
				this.newItem(i + 1);
				this.nextNew();
				return;
			}
		}
	}

	// Sélectionne (grâce au tableau this.items) et crée le nouveau slide après un changement automatique ou par l'utilisateur.
	newItem(range) {
        let image = this.createDivWithClass("new_carousel_image");
		image.appendChild(document.createElement("img"));
		image.querySelector("img").setAttribute("src", this.images[range].src);
		image.querySelector("img").setAttribute("alt", this.images[range].alt);
		image.querySelector("img").classList.add(this.images[range].classHTML);
		document.querySelector(".carousel_container").replaceChild(image, document.querySelector(".carousel_image"));
	}

	// Détermine la direction du nouveau slide.
	prevNew() {
		this.directionNewItem(1);
	}

	nextNew() {
		this.directionNewItem(-1);
	}

	// Définit l'animation du nouveau slide jusqu'à son arrêt.
	directionNewItem(direction) {
        let xItem = parseFloat(getComputedStyle(document.querySelector(".new_carousel_image")).left);
		if(direction < 0 && xItem === -1260) {
			xItem = -xItem;
		}
		let vitesse = 70;
		document.querySelector(".new_carousel_image").style.left = xItem + direction * vitesse + "px";
		if(direction > 0) {
			if(xItem < -70) {
				this.animationId = requestAnimationFrame(this.prevNew.bind(this));
			} else {
				cancelAnimationFrame(this.animationId);
                this.animationStop = true;
                document.querySelector(".new_carousel_image").classList.add('carousel_image');
				document.querySelector(".new_carousel_image").classList.remove("new_carousel_image");
			}
		}
		else {
			if(xItem > 70) {
				this.animationId = requestAnimationFrame(this.nextNew.bind(this));
			} else {
				cancelAnimationFrame(this.animationId);
                this.animationStop = true;
                document.querySelector(".new_carousel_image").classList.add('carousel_image');
				document.querySelector(".new_carousel_image").classList.remove("new_carousel_image");
			}
		}
	}

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
	new CarouselNewspaper();
});