console.log("script");

window.onload = function(){
    
    // Dark / Light theme
    let autoTheme = true;
    
    function dark(){
        $("body").removeClass("light");
        $("body").addClass("dark");
        $("main").removeClass("light");
        $("main").addClass("dark");
        $(".employees").removeClass("light");
        $(".employees").addClass("dark");
        $(".content").removeClass("light");
        $(".content").addClass("dark");
        $(".navbar").removeClass("bg-light");
        $(".navbar").removeClass("navbar-light");
        $(".navbar").addClass("bg-secondary");
        $(".navbar").addClass("navbar-secondary");
        $("footer").removeClass("bg-light");
        $("footer").addClass("bg-secondary");
        $('#navbarSupportedContent > ul > li > a').css('color', 'white');
        $('h1, h2, h3, h4, h5').css('color', 'white');
        $("container").removeClass("bg-light");
        $("container").addClass("bg-secondary");
        document.cookie = "theme=light; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        document.cookie = "theme=dark";
    }

    function light(){

        $("body").removeClass("dark");
        $("body").addClass("light");
        $("main").removeClass("dark");
        $("main").addClass("light");
        $(".employees").removeClass("dark");
        $(".employees").addClass("light");
        $(".content").removeClass("dark");
        $(".content").addClass("light");
        $(".navbar").removeClass("bg-secondary");
        $(".navbar").removeClass("navbar-secondary");
        $(".navbar").addClass("bg-light");
        $(".navbar").addClass("navbar-light");
        $("footer").removeClass("bg-secondary");
        $("footer").addClass("bg-light");
        $('#navbarSupportedContent > ul > li > a').css('color', 'black');
        $('h1, h2, h3, h4, h5').css('color', 'black');
        $("container").removeClass("bg-secondary");
        $("container").addClass("bg-light");
        document.cookie = "theme=dark; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        document.cookie = "theme=light";
    }
    

        $("#darkTrigger").click(function(){
            if($("body").hasClass("dark")){
                light();
                }
            else{
                dark();
                }
        });
    
        $(document).ready(function () {
         let d = new Date();
         let n = d.getHours();

                if(document.cookie === "theme=light"){
                    return;
                }else if(document.cookie === "theme=light"){
                    return;
                }else{
                    if(autoTheme){
                        if(n > 17 || n < 8){
                            autoTheme = false;
                            dark();
                        }else{
                            autoTheme = false;
                            light();
                        }     
                    }
                }
            });  
        
        
    //map Home Page
    let mymap = L.map('mapid').setView([50.8369069, 4.378142], 4460); 

    let map = L.tileLayer('https://tile.thunderforest.com/mobile-atlas/{z}/{x}/{y}.png?apikey=a0a047fedf024fa4925dfc14dc8fbd53', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 12,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'https://api.mapbox.com/geocoding/v5/mapbox.places/Los%20Angeles.json?access_token=YOUR_MAPBOX_ACCESS_TOKEN'
        });
        map.addTo(mymap);

        let marker = L.marker([50.8369069, 4.378142]).addTo(mymap);            
        marker.bindPopup("<b>Siège central de Nestlé</b><br>Rue du chocolat n°23<br>1000 Bruxelles<br>tel:02/687.70.70<br>email:info@nestle.be").openPopup();

};






