/**
 * @class Graphiques de la page "Women at work" du projet "Employees" réalisé dans le cadre du cours de Framework à l'EPFC
 * @author Grégory Van Ossel, Myriam Kadi, Simon Oldenhove
 * @version 1.0
 * 
 */

window.onload = function(){

    /**
     * Proportion de femmes et d’hommes au total 
     * @type Chart (chart.js)
     * @param {integer} nbWomen -> Le nombre de femmes totale parmis les employés
     * @param {integer} nbMen  -> Le nombre d'homme total parmis les employés
     */
    let ctx = document.getElementById('myChart');
    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Femmes employées', 'Hommes employés'],
            datasets: [{
                label: 'Proportion femmes/hommes',
                data: [nbWomen, nbMen],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    /**
     * Courbe annuelle du nombre de femmes au total
     * @type Chart (chart.js)
     * @param {array} yearWomen -> Les années durant lesquelles des femmes ont été employées
     * @param {array} nbHireWomen -> Les nombres de femmes employées par année
     */
    new Chart(document.getElementById("myLineChart"),
    {"type":"line","data":{"labels":yearWomen,
            "datasets":[{"label":"Courbe annuelle du nombre de femmes au total",
            "data":nbHireWomen,
            "fill":false,
            "borderColor":"rgb(255, 99, 132, 0.9)",
            "lineTension":0.1}]},"options":{legend:{display: false}}});

    /**
     * Proportion de femmes et d’hommes manager
     * @type Chart (chart.js)
     * @param {integer} nbWomenManager -> Le nombre de femmes manager
     * @param {integer} nbMenManager  -> Le nombre d'hommes manager
     */
    let ctx2 = document.getElementById('myDoughnutChart');
    let myDoughnutChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Femmes manager', 'Hommes manager'],
            datasets: [{
                label: 'Proportion femmes/hommes manager',
                data: [nbWomenManager, nbMenManager],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    /**
     * Les 3 départements présentant le plus de femmes
     * @type Chart (chart.js)
     * @param {array} depNameMoreWomen -> Tableau des 3 noms des départements contenant le plus de femmes
     * @param {array} nbDepMoreWomen  -> Tableau des nombres des 3 départements contenant le plus de femmes
     */
    new Chart(document.getElementById("myBarChart"),
    {"type":"bar","data":{"labels":depNameMoreWomen,
            "datasets":[{"label":false,
                    "data":nbDepMoreWomen,"fill":false,
                    "backgroundColor":["rgba(255, 99, 132, 0.4)","rgba(255, 99, 132, 0.3)","rgba(255, 99, 132, 0.2)"],
                    "borderColor":["rgb(255, 99, 132)","rgb(255, 99, 132)","rgb(255, 99, 132)"],
                    "borderWidth":1}]},"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]},legend:{display: false}}});

    /**
     * Les 3 départements présentant le moins de femmes
     * @type Chart (chart.js)
     * @param {integer} depNameLessWomen -> Tableau des 3 noms des départements contenant le moins de femmes
     * @param {integer} nbDepLessWomen  -> Tableau des nombres des 3 départements contenant le moins de femmes
     */
    new Chart(document.getElementById("myBarChart2"),
    {"type":"bar","data":{"labels":depNameLessWomen,
            "datasets":[{
                    "data":nbDepLessWomen,"fill":false,
                    "backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 99, 132, 0.3)","rgba(255, 99, 132, 0.4)"],
                    "borderColor":["rgb(255, 99, 132)","rgb(255, 99, 132)","rgb(255, 99, 132)"],
                    "borderWidth":1}]},"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]},legend:{display: false}}});
    
    
    
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