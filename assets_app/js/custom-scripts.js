/*------------------------------------------------------
    Author : www.webthemez.com
    License: Commons Attribution 3.0
    http://creativecommons.org/licenses/by/3.0/
---------------------------------------------------------  */

$(function () {
    "use strict";
    var mainApp = {

        initFunction: function () {
            /*MENU 
            ------------------------------------*/
            

            /* MORRIS BAR CHART
			-----------------------------------------*/
            


            /* MORRIS DONUT CHART
            ----------------------------------------*/
            $.getJSON(get_status, function (stts) {
                // console.log(stts[0]);
                Morris.Donut({
                    element: 'morris-donut-chart',
                    data: [{
                        label: "Masih Pending",
                        value: stts[0].pending
                    }, {
                        label: "Telah Disetujui",
                        value: stts[0].diterima
                    }, {
                        label: "Telah Ditolak",
                        value: stts[0].ditolak
                    }],colors: [
                        '#f0ad4e',
                        '#337ab7',
                        '#d9534f' 
                    ],
                    resize: true
                });
            });

            /* MORRIS AREA CHART
			----------------------------------------*/
            

            /* MORRIS LINE CHART
			----------------------------------------*/
            
        
            
            $('.donut-chart').cssCharts({type:"donut"}).trigger('show-donut-chart');
        },

        initialization: function () {
            mainApp.initFunction();

        }

    }
    // Initializing ///

    $(document).ready(function () {
        mainApp.initFunction(); 
    });

}(jQuery));
