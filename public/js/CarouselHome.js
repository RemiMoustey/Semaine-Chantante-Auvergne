/*
	Cette classe met en place le diaporama présent en haut de la page
*/

class CarouselHome {

	// Crée l'objet et met à disposition le tableau des slides
	constructor() {
		this.slides = this.createDivWithClass("slides");
		this.container = this.createDivWithClass("carousel_container");
		this.slides.appendChild(this.container);
		this.images = [this.getImage("./public/img/1.png", "Volcans du département du Puy-de-Dôme", "image-1"),
		this.getImage("./public/img/2.png", "Image de choristes", "image-2")];
		this.intervalId = null;
		this.animationStop = false;
		this.createNavigation();
	}

	/*
		Met en place les animations du diaporama en appelant la fonction nécessaire
	*/
	createNavigation () {
		let callNext = this.determineNewItem.bind(this);
		this.intervalId = setInterval(callNext, 5000);
	}

	/*
		Sélectionne le slide suivant
	*/
	determineNewItem() {
		if(this.animationStop)
		{
			clearInterval(this.intervalId);
		}
		else if(document.querySelector("img").classList.contains("image-1")) {
			this.newItem(1);
			return;
		}
		else if(document.querySelector("img").classList.contains("image-2")) {
			this.newItem(0);
			return;
		}
	}

	// Sélectionne (grâce au tableau this.images) et crée le nouveau slide après un changement automatique ou par l'utilisateur.
	newItem(range) {
		let image = this.createDivWithClass("new-img");
		$("#carousel_item").append(image);
		$(".new-img").html('<img src="' + this.images[range].src + '" alt="' + this.images[range].alt + '" class="' + this.images[range].classHTML + '" />');
		
		let classImage = '';
		if (document.querySelector('img').classList[0] === 'image-1')
		{
			classImage = '.image-1';
		}
		else
		{
			classImage = '.image-2';
		}
		$('.new-img').css("position", "absolute");
		if (screen.width > 767) {
			$('.new-img').css("top", "50px");
		}
		else {
			$('.new-img').css("top", "290px");
		}
		$('.new-img').css("display", "none");
		
		$('.new-img').fadeIn(2000).queue(function() {
			$('.new-img').css("display", "block");
			$('.printed_image').remove();
			$('.new-img').addClass('printed_image');
			$('.new-img').removeClass('new-img');
			$(this).dequeue();
		});
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

new CarouselHome;