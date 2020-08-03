$(function () {
  $.getJSON(get_data_aset, function (tot) {
    var ctx, data, myLineChart, options;
    Chart.defaults.global.responsive = true;
    ctx = $('#pie-chart').get(0).getContext('2d');
    options = {
      showScale: false,
      scaleShowGridLines: false,
      scaleGridLineColor: "rgba(0,0,0,.05)",
      scaleGridLineWidth: 0,
      scaleShowHorizontalLines: false,
      scaleShowVerticalLines: false,
      bezierCurve: false,
      bezierCurveTension: 0.4,
      pointDot: false,
      pointDotRadius: 0,
      pointDotStrokeWidth: 2,
      pointHitDetectionRadius: 20,
      datasetStroke: true,
      datasetStrokeWidth: 4,
      datasetFill: true,
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
    };
    data = [
      {
        value: tot[0].tot_penghapusan,
        color: "#DB2500",
        highlight: "#FA0000",
        label: "Data Penghapusan"
      }, {
        value: tot[0].tot_aset_b,
        color: "#1ABC9C",
        highlight: "#13D1AC",
        label: "Aset Layak Pakai"
      }, {
        value: tot[0].tot_pemeliharaan_in,
        color: "#DEA923",
        highlight: "#FABE28",
        label: "Pemeliharaan Internal Masih Proses"
      },{
        value: tot[0].tot_pemeliharaan_ex,
        color: "#1ec74b",
        highlight: "#23e857",
        label: "Pemeliharaan External Masih Proses"
      }, {
        value: tot[0].tot_pemeliharaan_selesai_in,
        color: "#44524d",
        highlight: "#728a81",
        label: "Pemeliharaan Internal Selesai"
      }, {
        value: tot[0].tot_pemeliharaan_selesai_ex,
        color: "#1f2194",
        highlight: "#2f32e0",
        label: "Pemeliharaan External Selesai"
      },{
        value: tot[0].tot_aset_rr,
        color: "#824087",
        highlight: "#bd5ac4",
        label: "Aset Rusak Ringan"
      }, {
        value: tot[0].tot_aset_rb,
        color: "#456e4a",
        highlight: "#72b57a",
        label: "Aset Rusak Berat"
      }
    ];
    myLineChart = new Chart(ctx).Pie(data, options);
  });
});