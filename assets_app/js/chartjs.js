$(function () {
	$.getJSON(get_status, function (stts) {
		var tot_pending = Number(stts[0].pending);
		var tot_diterima = Number(stts[0].diterima);
		var tot_ditolak = Number(stts[0].ditolak);

		var pending = tot_pending.toFixed(2);
		var diterima = tot_diterima.toFixed(2);
		var ditolak = tot_ditolak.toFixed(2);

		var chart = new CanvasJS.Chart("usulanPengadaan", {
			exportEnabled: false,
			animationEnabled: false,
			title: {
				text: ""
			},
			legend: {
				cursor: "pointer",
				itemclick: explodePie
			},
			data: [{
				type: "pie",
				startAngle: 250,
				showInLegend: true,
				toolTipContent: "{name}: <strong>{y}%</strong>",
				indexLabel: "{name} - {y}%",
				dataPoints: [{
						y: pending,
						name: "Pending",
						exploded: true
					},
					{
						y: diterima,
						name: "Diterima",
						exploded: true
					},
					{
						y: ditolak,
						name: "Ditolak",
						exploded: true
					}
				]
			}]
		});
		chart.render();
	});
  

	$.getJSON(get_data_aset, function (tot) {
		// Mengubah string ke number
		var tot_aset_b = Number(tot[0].tot_aset_b);
		var tot_aset_rr = Number(tot[0].tot_aset_rr);
		var tot_aset_rb = Number(tot[0].tot_aset_rb);
		var tot_pemeliharaan_in = Number(tot[0].tot_pemeliharaan_in);
		var tot_pemeliharaan_ex = Number(tot[0].tot_pemeliharaan_ex);
		var tot_pemeliharaan_selesai_in = Number(tot[0].tot_pemeliharaan_selesai_in);
		var tot_pemeliharaan_selesai_ex = Number(tot[0].tot_pemeliharaan_selesai_ex);

		// Mengambil 2 angka di belakang koma
		var aset_b = tot_aset_b.toFixed(2);
		var aset_rr = tot_aset_rr.toFixed(2);
		var aset_rb = tot_aset_rb.toFixed(2);
		var pemeliharaan_in = tot_pemeliharaan_in.toFixed(2);
		var pemeliharaan_ex = tot_pemeliharaan_ex.toFixed(2);
		var pemeliharaan_selesai_in = tot_pemeliharaan_selesai_in.toFixed(2);
		var pemeliharaan_selesai_ex = tot_pemeliharaan_selesai_ex.toFixed(2);

		// console.log(tot_aset_b);
		var chart = new CanvasJS.Chart("asetPerkategori", {
			exportEnabled: false,
			animationEnabled: false,
			title: {
				text: ""
			},
			legend: {
				cursor: "pointer",
				itemclick: explodePie
			},
			data: [{
				type: "pie",
				startAngle: 250,
				showInLegend: true,
				toolTipContent: "{name}: <strong>{y}%</strong>",
				indexLabel: "{name} - {y}%",
				dataPoints: [{
						y: aset_b,
						name: "Aset Layak Pakai",
						exploded: true
					},
					{
						y: pemeliharaan_in,
						name: "Pemeliharaan Internal Masih Proses",
						exploded: true
					},
					{
						y: pemeliharaan_ex,
						name: "Pemeliharaan External Masih Proses",
						exploded: true
					},
					{
						y: pemeliharaan_selesai_in,
						name: "Pemeliharaan Internal Selesai",
						exploded: true
					},
					{
						y: pemeliharaan_selesai_ex,
						name: "Pemeliharaan External Selesai",
						exploded: true
					},
					{
						y: aset_rr,
						name: "Aset Rusak Ringan",
						exploded: true
					},
					{
						y: aset_rb,
						name: "Aset Rusak Berat",
						exploded: true
					}
				]
			}]
		});
		chart.render();
  });
  
  function explodePie(e) {
		if (typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
			e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
		} else {
			e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
		}
		e.chart.render();

  }
});
