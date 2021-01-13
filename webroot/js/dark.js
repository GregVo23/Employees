console.log("script");

window.onload = function(){
    
    /**
     * Function dark to switch screen to dark mode
     * @var autoTheme Boolean to switch on the time
     */
    let autoTheme = true;
    function dark(){
        $("td.actions > a > img").addClass("filterLight");
        $(".logo").addClass("filterLight");
        $(".logoHome").addClass("filterLight");
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
        document.cookie = "theme=dark; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        document.cookie = "theme=light; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        document.cookie = "theme=dark";
    }
    /**
     * Function dark to switch screen to dark mode
     * @var autoTheme Boolean to switch on the time
     */
    function light(){
        $("td.actions > a > img").removeClass("filterLight");
        $(".logo").removeClass("filterLight");
        $(".logoHome").removeClass("filterLight");
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
        document.cookie = "theme=light; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        document.cookie = "theme=dark; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        document.cookie = "theme=light";
    }
    
        //Button to switch to darkmode - lightmode
        $("#darkTrigger").click(function(){

            if($("body").hasClass("dark")){
                light();
            }else if($("body").hasClass("light")){
                dark();
            }else if(autoTheme){
                if(n > 17 || n < 8){
                    light();
                }else{
                    dark();
                }     
            }           
        });
        //if not cookie switch on time to darkmode - lightmode    
        $(document).ready(function () {
         let d = new Date();
         let n = d.getHours();

                if(document.cookie === "theme=light"){
                    light(); 
                }else if(document.cookie === "theme=dark"){
                    dark();
                }else{
                    if(autoTheme){
                        if(n > 17 || n < 8){
                            dark();
                        }else{
                            light();
                        }     
                    }
                }
            });  
            if($("body").hasClass("dark") || $("body").hasClass("light")){
                autoTheme = false;
            };

};






