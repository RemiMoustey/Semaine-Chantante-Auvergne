class Map {
    constructor() {
        this.background = this.getBackgroundMap();
        this.chambon = this.getIcon();
    }

    getBackgroundMap() {
        let map = L.map('mapid').setView([45.5713, 2.89683], 10);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoicmVtaW02MyIsImEiOiJjankwMHE3bGkwMnM3M2RsazRkMjRmYmYwIn0.kZsG98EgabFQ5DNubAZTsg'
        }).addTo(map);

        return map;
    }

    getIcon() {
        let icon = L.icon({
            
        });
    }
}

new Map();