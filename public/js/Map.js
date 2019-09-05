class Map {
    constructor() {
        this.chair = this.createIcon("chair");
        this.show = this.createIcon("show");
        this.holiday = this.createIcon("holiday");

        this.background = this.getBackgroundMap();
    }

    createIcon(name)
    {
        return L.icon({
            iconUrl: "./public/img/" + name + ".png",
            iconSize: [45, 60],
            iconAnchor: [22, 60],
            popupAnchor: [0, -60]
        });
    }

    getBackgroundMap() {
        let map = L.map('mapid').setView([45.6913, 2.89683], 10);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoicmVtaW02MyIsImEiOiJjankwMHE3bGkwMnM3M2RsazRkMjRmYmYwIn0.kZsG98EgabFQ5DNubAZTsg'
        }).addTo(map);

        let places = [[L.marker([45.572055, 2.924638], {icon: this.holiday}), "Village de vacances Le Grand Panorama, lieu d'hébergement de la Semaine Chantante."],
        [L.marker([45.7726, 3.08868], {icon: this.show}), "Théâtre de Verdure de Clermont-Ferrand au centre du Jardin Lecoq. Parc de verdure de 5 hectares."],
        [L.marker([45.587555, 2.737119], {icon: this.show}), "Salle de spectacle du Casino de La Bourboule (1500 places)."],
        [L.marker([45.788078, 3.100355], {icon: this.show}), "Coopérative de Mai. Salle de spectacle (1000 places), pour repli en cas de pluie."],
        [L.marker([45.773966, 3.097436], {icon: this.chair}), "Siège social du groupe vocal Aquarelle."]];

        let popup = L.popup();
        for (let place of places)
        {
            place[0].addTo(map)
            place[0].on('mouseover', function() {
                popup.setContent(place[1]);
                this.bindPopup(popup).openPopup();
            });
        }

        return map;
    }
}

new Map();
