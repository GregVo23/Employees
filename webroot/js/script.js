console.log("script");






window.onload = function(){
    
    
    // Dark / Light theme
    function dark(){
        $("body").addClass("dark");
        $("main").addClass("dark");
        $(".employees").addClass("dark");
        $(".content").addClass("dark");
        $(".navbar").removeClass("bg-light");
        $(".navbar").removeClass("navbar-light");
        $(".navbar").addClass("bg-secondary");
        $(".navbar").addClass("navbar-secondary");
        $("footer").removeClass("bg-light");
        $("body > footer").removeClass("bg-light");
        $("footer").addClass("bg-secondary");
        $("body > footer").addClass("bg-secondary");
        $('#navbarSupportedContent > ul > li > a').css('color', 'white');
    }

    function light(){
        $("body").removeClass("dark");
        $("main").removeClass("dark");
        $(".employees").removeClass("dark");
        $(".content").removeClass("dark");
        $(".navbar").addClass("bg-light");
        $(".navbar").addClass("navbar-light");
        $(".navbar").removeClass("bg-secondary");
        $(".navbar").removeClass("navbar-secondary");
        $("footer").addClass("bg-light");
        $("body > footer").addClass("bg-light");
        $("footer").removeClass("bg-secondary");
        $("body > footer").removeClass("bg-secondary");
        $('#navbarSupportedContent > ul > li > a').css('color', 'black');
    }
    
    
    if(localStorage.getItem('theme')==="dark"){
        dark();
    }else if(localStorage.getItem('theme')==="light"){
        light();
    }
    
        $("#darkTrigger").click(function(){
        if($("body").hasClass("dark")){
            localStorage.clear()
            localStorage.setItem('theme', 'light');
            console.log(localStorage);
            light();
            }
        else{
            localStorage.clear()
            localStorage.setItem('theme', 'dark');
            console.log(localStorage);
            dark();
            }
        });
    
        $(document).ready(function () {
         let d = new Date();
         let n = d.getHours();

            if(localStorage.getItem('theme')!== 'undefinded'){
                if(n > 17 || n < 8){
                    localStorage.setItem('theme', 'dark');
                    $("body").addClass("dark");
                    $("main").addClass("dark");
                    $(".employees").addClass("dark");
                    $(".content").addClass("dark");
                    $(".navbar").addClass("bg-secondary");
                    $(".navbar").addClass("navbar-secondary");
                    $("footer").addClass("bg-secondary");
                    $("body > footer").addClass("bg-secondary");
                    $('#navbarSupportedContent > ul > li > a').css('color', 'white');
                }else{
                    localStorage.setItem('theme', 'light');
                }
            }else if(localStorage.getItem('theme')=== 'light')
            {
                light();
            }else if(localStorage.getItem('theme')=== 'dark'){
                dark();
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






