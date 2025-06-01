(() => {
  const draw = SVG().addTo("#main-map").size(1200, 450);
  const geoLeft = 95.22025;
  const geoTop = 7.356505;
  const geoRight = 141.009728;
  const geoBot = -10.946766;

  const geoW = geoRight - geoLeft;
  const geoH = geoTop - geoBot;
  const imgW = 792.54596;
  const imgH = 316.66394;

  const convertCoordinate = (coordinate) => {
    const spl = String(coordinate).split(",");
    const lat = Number(spl[0].trim());
    const lng = Number(spl[1].trim());

    return {
      x: ((lng - geoLeft) / geoW) * imgW,
      y: ((geoTop - lat) / geoH) * imgH,
    };
  };

  const gMain = draw.group().transform({
    translate: [10, 20],
    scale: 1.5,
    origin: "top left",
  });
  const g = gMain.group();

  for (const p of window.dataProvinsi) {
    if (!p.path_data) continue;
    g.path(p.path_data)
      .fill(p.background_color)
      .stroke({ color: "#474f7d", width: 0.5 });
  }

  const gKanwil = gMain.group();
  for (const k of window.dataKanwil) {
    const anggota = [
      {
        photo: null,
        name: "Budi",
        office: "KPPBC Tipe Madya Pabean C Sabang",
      },
      {
        photo: null,
        name: "Anton",
        office: "KPPBC Tipe Madya Pabean C Meulaboh",
      },
    ];

    const anggotaHtml = anggota.map((a) => {
      return `<div class="flex flex-row gap-1">
        <div class="w-[95px] flex-none">${a.name}</div>
        <div class="flex-auto">${a.office}</div>
      </div>`;
    });

    const { x, y } = convertCoordinate(k.coordinate);
    const cg = gKanwil
      .group()
      .css("cursor", "pointer")
      .data("toggle", "popover")
      .data("bs-title", k.shortname)
      .data(
        "bs-content",
        `<div class="flex flex-column gap-2 w-full">
          <span class="text-gray-500" style="font-size: 12px;">Anggota Bertugas</span>
          <div style="flex flex-column gap-2">${anggotaHtml.join("")}</div>
        </div>`,
      )
      .on("click", function () {
        $("#modalDetailLabel").text(k.shortname);
        const body = $("#modalDetail").find(".modal-c");
        body.empty();

        const container = $("<div />");
        const svgCont = $("<div />");
        const d = SVG().addTo(svgCont[0]).size(600, 600);
        const g = d.group();
        const gBorder = g.group();
        const gOff = g.group();

        const el = [];
        for (const p of window.dataProvinsi) {
          if (!p.path_data) continue;
          const offId = String(p.office_id).split(",");
          if (offId.includes(String(k.id))) {
            el.push(gBorder.path(p.path_data).fill("#fbfbfe"));
          }
        }

        const bb = gBorder.bbox();
        const { x, y, w, h } = bb;

        const wScale = 600 / w;
        const hScale = 600 / h;
        const scale = Math.min(wScale, hScale);
        g.translate(-x, -y);
        g.scale(scale, x, y);

        for (const off of window.allOffice) {
          if (off.parent_id != k.id && off.id != k.id) continue;
          if (!off.coordinate) continue;
          const { x, y } = convertCoordinate(off.coordinate);
          gOff
            .circle(10 / scale)
            .fill("#f00")
            .move(x - 5 / scale, y - 5 / scale);
        }

        for (const e of el) e.stroke({ color: "#4A517F", width: 1 / scale });
        d.size(scale * w, scale * h);
        container.append(svgCont);

        const data = $("<div />");
        data.append();

        container.append(data);
        container.addClass("flex");
        body.append(container);

        $("#modalDetail").modal("show");
      });

    cg.circle(18)
      .fill("#e8636d")
      .opacity(0.2)
      .move(x - 9, y - 9);
    cg.circle(10)
      .fill("#e8636d")
      .opacity(0.6)
      .move(x - 5, y - 5);
    cg.circle(6)
      .fill("#fff")
      .move(x - 3, y - 3);
  }

  $('[data-toggle="popover"]').each((_idx, el) => {
    new bootstrap.Popover(el, {
      container: "body",
      trigger: "hover",
      html: true,
    });
  });
})();
