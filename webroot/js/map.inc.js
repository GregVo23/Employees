console.log("map");

window.onload = function(){
   let mymap = L.map('mapid').setView([50.8369069, 4.378142], 4460); 

        let map = L.tileLayer('https://tile.thunderforest.com/landscape/{z}/{x}/{y}.png?apikey=a0a047fedf024fa4925dfc14dc8fbd53', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'https://api.mapbox.com/geocoding/v5/mapbox.places/Los%20Angeles.json?access_token=YOUR_MAPBOX_ACCESS_TOKEN'
            });
            map.addTo(mymap);
            
            
            let marker = L.marker([50.8369069, 4.378142]).addTo(mymap);            
            marker.bindPopup("<b>Siège central de Nestlé</b><br>Rue du chocolat n°23<br>1000 Bruxelles<br>tel:02/687.70.70<br>email:info@nestle.be").openPopup();
};






