window.processIndex = function ({
  dataJnpp,
  colorJnpp,
  labelJnpp,
  dataCase,
  mapColor,
  selectedReg,
  tooltipsData,
}) {
  let tooltipsDataArray = [];
  for (var i in tooltipsData) tooltipsDataArray[i] = tooltipsData[i];

  let dataJnppArray = [];
  for (var i in dataJnpp) dataJnppArray.push(dataJnpp[i]);

  let dataCaseArray = [];
  let dataTangkapanArray = [];
  let label_month = [];
  for (var i in dataCase) {
    dataCaseArray.push(dataCase[i].kasus);
    label_month.push(dataCase[i].label);
    dataTangkapanArray.push(dataCase[i].tangkapan);
  }

  jQuery(document).ready(function () {
    drawMap(selectedReg);
    drawJnpp();
    drawKasus();
    $("#provinsi").on("change", function () {
      $("#vmap").remove();
      $("#map-body").html('<div id="vmap""></div>');
      drawMap($(this).val());
      $("#keterangan").html();
      if ($(this).val()) {
        $("#keterangan").html(
          "Data Provinsi " + $(this).children("option:selected").text() + " ",
        );
      } else {
        $("#keterangan").html("Data Seluruh Indonesia ");
      }
    });

    $(window).on("resize", sizeMap);
  });

  const sizeMap = () => {
    var containerWidth = $(".map-container").width(),
      containerHeight = containerWidth / 3.7;

    $("#vmap").css({
      width: containerWidth,
      height: containerHeight,
    });
  };

  const fillModal = (provinsi, tahun, c, p) => {
    const path = window.regionPath.paths[provinsi];
    const b = window.getBounds(path.path);

    $("#prov-map").empty();
    const w = Math.abs(b[2] - b[0]);
    const h = Math.abs(b[3] - b[1]);

    const sw = 600 / w;
    const sh = 600 / h;
    const s = Math.min(sw, sh);

    var draw = SVG().addTo("#prov-map").size(600, 600);
    draw
      .path(path.path)
      .move(0, 0)
      .size(w * s, h * s)
      .fill("#fff")
      .stroke("#000");

    // $("#prov-path").attr(
    //   "d",
    //   window.normalizePath({ path: "M 0 0 " + path.path, min: 0, max: 600 }),
    // );

    return;

    $.ajax({
      url: "{$path}",
      type: "get",
      data: "code=" + provinsi + "&tahun=" + tahun + "&c=" + c + "&page=" + p,
      beforeSend: function () {},
      success: function (data) {
        $("#modalDetailLabel").html(data.name);
        $("#code").val(provinsi);
        $("#page-modal").val(data.page);
        if (data.data) {
          d = data.data;
          tmpl = "";
          pagination = "";
          $("#tbl-penangkapan").html("Data tidak ditemukan");
          $("#pagination-modal").html("");
          for (i = 0; i < d.length; i++) {
            tmpl += '<div class="d-flex flex-row bd-highlight tbl-box">';
            tmpl += '<div class="tbl-no">' + (i + 1) + "</div>";
            tmpl +=
              '<div class="tbl-base"><div class="text-sm m-0 p-0 text-start">' +
              d[i].date +
              '</div><div class="m-0 p-0 font-bold">Penangkapan ' +
              data.name +
              "</div></div>";
            tmpl +=
              '<div class="d-flex case-summary"><div class="div-material"><span class="material-icons-outlined">flight_takeoff</span> ' +
              d[i].udara +
              "</div>";
            tmpl +=
              '<div class="div-material"><span class="material-icons-outlined">anchor</span> ' +
              d[i].laut +
              "</div>";
            tmpl +=
              '<div class="div-material"><span class="material-icons">local_shipping</span> ' +
              d[i].darat +
              "</div>";
            tmpl += " </div>";
            tmpl +=
              '<div class="tbl-item-total"><div class="text-sm m-0 p-0">Total </div><div class="m-0 p-0 font-bold">' +
              d[i].total +
              "</div></div>";
            tmpl +=
              '<div class="tbl-item"><div class="text-sm m-0 p-0">Meth</div><div class="m-0 p-0 font-bold">' +
              d[i].meth +
              "</div></div>";
            tmpl +=
              '<div class="tbl-item"><div class="text-sm m-0 p-0">Cocaine</div><div class="m-0 p-0 font-bold">' +
              d[i].cocaine +
              "</div></div>";
            tmpl +=
              '<div class="tbl-item"><div class="text-sm m-0 p-0">Ganja</div><div class="m-0 p-0 font-bold">' +
              d[i].ganja +
              "</div></div>";
            tmpl +=
              '<div class="tbl-item"><div class="text-sm m-0 p-0">MDMA </div><div class="m-0 p-0 font-bold">' +
              d[i].mdma +
              "</div></div>";
            tmpl +=
              '<div class="tbl-item"><div class="text-sm m-0 p-0">Lainnya </div><div class="m-0 p-0 font-bold">' +
              d[i].lainnya +
              "</div></div>";
            tmpl +=
              '<div class="tbl-item-surat"><div class="text-sm m-0 p-0">Surat Tugas </div><div class="m-0 p-0 font-bold"><a class="text-warning" href="' +
              d[i].surat_tugas_url +
              '">' +
              d[i].surat_tugas +
              "</a></div></div>";
            tmpl +=
              '<div class="button-laporan"><a class="btn btn-outline-warning" href="' +
              d[i].laporan +
              '">Unduh Dokumen</a></div>';

            tmpl += "</div>";
          }
          if (tmpl != "") {
            $("#tbl-penangkapan").html(tmpl);

            if (data.totalPage > 1) {
              pagination = '<ul class="pagination justify-content-left">';
              start = data.page > 1 ? data.page - 1 : 1;
              disabledPrev = data.page == 1 ? "disabled" : "";
              if (data.page > 2) {
                pagination +=
                  '<li class="page-item ' +
                  disabledPrev +
                  '"><a data-id="' +
                  (data.page - 1) +
                  '" class="page-link page-btn" href="#" type="button"><span class="material-icons text-sm">skip_previous</span></a></li>';
              }
              pagination +=
                '<li class="page-item ' +
                disabledPrev +
                '"><a data-id="' +
                (data.page - 1) +
                '" class="page-link" href="#" type="button"><span class="material-icons text-sm">arrow_back_ios</span></a></li>';
              for (i = start; i <= data.totalPage; i++) {
                isActive = i == data.page ? "active" : "";
                pagination +=
                  '<li class="page-item ' +
                  isActive +
                  '"><a data-id="' +
                  i +
                  '"  class="page-link page-btn" href="#">' +
                  i +
                  "</a></li>";
              }
              if (data.page < data.totalPage - 2) {
                pagination +=
                  '<li class="page-item"><a data-id="' +
                  data.totalPage +
                  '" class="page-link" href="#"><span class="material-icons">skip_next</span></a></li>';
              }

              disabledNext = data.page == data.totalPage ? "disabled" : "";
              pagination +=
                '<li class="page-item ' +
                disabledNext +
                '"><a data-id="' +
                data.totalPage +
                '" class="page-link" href="#"><span class="material-icons text-sm">arrow_forward_ios</span></a></li>';
              pagination += "</ul>";
              $("#pagination-modal").html(pagination);
            }
          }
        }
      },
    });
  };

  const drawMap = (selectedRegions = null) => {
    sizeMap();
    regionColor = "#c3d3e3";
    console.log(mapColor[selectedRegions]);
    console.log(selectedRegions);
    if (selectedRegions !== null) {
      regionColor = mapColor[selectedRegions];
    }
    jQuery("#vmap").vectorMap({
      map: "indonesia_id",
      enableZoom: false,
      showTooltip: true,
      selectedColor: regionColor,
      scaleColors: ["#b6d6ff", "#005ace"],
      color: "#c3d3e3",
      selectedRegions: selectedRegions,
      hoverOpacity: null,
      borderColor: "#818181",
      borderOpacity: 0.25,
      borderWidth: 1,
      hoverColor: "#dedede",
      backgroundColor: "#252733",
      markerStyle: {
        initial: {
          fill: "#F8E23B",
          stroke: "#383f47",
        },
      },
      markers: [[1, 2]],
      onRegionClick: function (event, code, region) {
        fillModal(code, "", "", 1);
        $("#modalDetail").modal("show");
      },
      onLabelShow: function (event, label, code) {
        var regionName = label[0].innerHTML;
        // if()

        let tooltip = [
          '<table class="table-tooltip table-light">',
          '<tr><td class="text-tooltip-header"><b>' +
            regionName +
            "</b></td></tr>",
        ];

        if (tooltipsDataArray[code]) {
          for (i = 0; i < tooltipsDataArray[code].length; i++) {
            dt =
              '<tr><td class="text-sm text-center " style="vertical-align:end"><span class="material-icons-round text-warning">people</span> ' +
              tooltipsDataArray[code][i].dalam_tugas +
              " dalam tugas</td></tr>";
            tooltip.push(dt);
          }
        }

        tooltip.push("</table>");
        label[0].innerHTML = tooltip.join("");
      },
    });
    if (!selectedReg) {
      jQuery("#vmap").vectorMap("set", "colors", { ...mapColor });
    }
  };

  $(".btn-close").on("click", function () {
    $("#vmap").remove();
    $("#map-body").html('<div id="vmap""></div>');
    drawMap(selectedReg);
    setTimeout(function () {
      if (!$("#modalDetail").hasClass("show")) {
        window.location.reload(1);
      }
    }, 30000);
  });

  $("#tahun-modal").on("change", function () {
    code = $("#code").val();
    c = $("#case-modal").val();
    p = $("#page-modal").val();
    fillModal(code, $(this).val(), c, p);
  });

  $("#tahun-modal").on("change", function () {
    code = $("#code").val();
    c = $("#case-modal").val();
    p = $("#page-modal").val();
    tahun = $("#tahun-modal").val();
    fillModal(code, tahun, c, p);
  });

  $("#pagination-modal").on("click", ".page-link", function () {
    code = $("#code").val();
    c = $("#case-modal").val();
    p = $(this).data("id");
    tahun = $("#tahun-modal").val();
    fillModal(code, tahun, c, p);
  });

  $("#case-modal").on("change", function () {
    code = $("#code").val();
    c = $("#case-modal").val();
    p = $("#page-modal").val();
    tahun = $("#tahun-modal").val();
    fillModal(code, tahun, c, p);
  });

  $(".search-btn").on("change", function () {
    $("#search-form").submit();
  });

  let progressWidth = document.getElementsByClassName("progressbar-width");

  let progress = document.getElementsByClassName("progress");
  let progressBar = document.getElementsByClassName("progress-bar");

  function move(elem, maxwidth) {
    var width = 1;
    var id = setInterval(frame, 10);
    function frame() {
      if (width >= maxwidth) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
      }
    }
  }

  function moveTotal() {
    var width = 1;
    var id = setInterval(frame, 5);
    let total = Number("{$total}");
    function frame() {
      if (width >= total) {
        clearInterval(id);
        i = 0;
      } else {
        let pembagi = total > 1000 ? 100 : total;
        width += Math.floor(total / pembagi);
        if (width > total) {
          width = total;
        }
        $(".text-total").html(width);
      }
    }
  }

  function moveCase(elem, ttl) {
    var width = 1;
    var id = setInterval(frame, 5);
    function frame() {
      if (width >= ttl) {
        clearInterval(id);
        i = 0;
      } else {
        let pembagi = ttl > 1000 ? 100 : ttl;
        width += Math.floor(ttl / pembagi);
        if (width > ttl) {
          width = ttl;
        }
        elem.html(width);
      }
    }
  }

  const drawJnpp = () => {
    const bgc = ["#FBB03B", "#252733"];
    const data = {
      labels: labelJnpp,
      datasets: [
        {
          data: dataJnpp,
          backgroundColor: colorJnpp,
          hoverOffset: 3,
          borderWidth: 0,
          cutout: "0%",
          borderRadius: 2,
        },
      ],
    };

    const config = {
      type: "doughnut",
      data,
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false,
          },
        },
        animation: {
          duration: 3000,
        },
      },
    };

    const chartJpn = new Chart(document.getElementById("jnpp"), config);
  };

  const drawKasus = () => {
    const dataKasus = {
      labels: label_month,
      datasets: [
        {
          label: "Total Kasus",
          data: dataCaseArray,
          backgroundColor: "#FBB03B",
          borderColor: "#FBB03B",
          yAxisID: "case",
          type: "line",
        },
        {
          label: "Total BB",
          data: dataTangkapanArray,
          backgroundColor: "#25B0FF",
          borderColor: "#25B0FF",
          // fill: true,
          yAxisID: "bb",
          type: "bar",
        },
      ],
    };

    const configKasus = {
      // type: 'line',
      data: dataKasus,
      options: {
        scales: {
          case: {
            type: "linear",
            position: "left",
          },
          bb: {
            type: "linear",
            position: "right",
          },
        },
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        animation: {
          duration: 3000,
        },
      },
    };

    const chartKasus = new Chart(document.getElementById("kasus"), configKasus);
  };
};
