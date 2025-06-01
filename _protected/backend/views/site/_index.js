(() => {
  const anggotaAtOfficeExists = (officeId) => {
    return window.anggota.some((a) => {
      return String(a.id_office) === String(officeId);
    });
  };

  const anggotaAtKanwilExists = (officeId) => {
    for (const off of window.allOffice) {
      if (String(off.parent_id) !== String(officeId) && off.id !== officeId) {
        continue;
      }

      if (anggotaAtOfficeExists(off.id)) {
        return true;
      }
    }

    return false;
  };

  const anggotaAtOffice = (officeId) => {
    return window.anggota.filter((a) => {
      return String(a.id_office) === String(officeId);
    });
  };

  const anggotaAtKanwil = (officeId) => {
    const anggota = [];
    for (const off of window.allOffice) {
      if (String(off.parent_id) !== String(officeId) && off.id !== officeId) {
        continue;
      }

      const a = anggotaAtOffice(off.id);
      for (const x of a) {
        anggota.push({
          anggota: x,
          office: off,
        });
      }
    }

    return anggota;
  };

  const dataKanwil = window.allOffice.filter((off) => {
    let exists = false;
    for (const p of window.dataProvinsi) {
      if (String(p.office_id).split(",").includes(String(off.id))) {
        exists = true;
        break;
      }
    }

    return exists;
  });

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

  for (const k of dataKanwil) {
    const thisKanwilAnggota = anggotaAtKanwil(k.id);
    const anggotaHtml = thisKanwilAnggota.map((a) => {
      return `<div class="flex flex-row gap-1">
        <div class="w-[95px] flex-none">${a.anggota.name}</div>
        <div class="flex-auto">${a.office.shortname}</div>
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
        anggotaHtml.length
          ? `<div class="flex flex-column gap-2 w-full">
          <span class="text-gray-500" style="font-size: 12px;">Anggota Bertugas</span>
          <div style="flex flex-column gap-2">${anggotaHtml.join("")}</div>
        </div>`
          : `<span class="text-gray-500" style="font-size: 12px;">Tidak ada anggota bertugas</span>`,
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
            .fill("#FBB03B")
            .move(x - 5 / scale, y - 5 / scale);
        }

        for (const e of el) e.stroke({ color: "#4A517F", width: 1 / scale });
        d.size(scale * w, scale * h);
        container.append(svgCont);

        const data = $(`<div class="flex flex-column gap-4" />`);
        const anggotaBertugas = $(`<div class="flex flex-column gap-2"/>`);
        const anggotaBertugasTitle = $(
          `<div class="flex items-center gap-2 text-abu"><span class="material-symbols-outlined">account_circle</span><span>Anggota Bertugas</span></div>`,
        );
        const anggotaBertugasCont = $(
          `<div class="flex flex-row flex-wrap gap-2" />`,
        );
        if (thisKanwilAnggota.length) {
          for (const kwa of thisKanwilAnggota) {
            anggotaBertugasCont.append(
              `<div class="flex flex-row gap-1 bg-[#eaeaea] py-1 px-2 rounded-md">
                <div class="">${kwa.anggota.name}</div>
              </div>`,
            );
          }
        } else {
          anggotaBertugasCont.append(
            `<span class="text-gray-500" style="font-size: 12px;">Tidak ada anggota bertugas</span>`,
          );
        }

        anggotaBertugas.append(anggotaBertugasTitle);
        anggotaBertugas.append(anggotaBertugasCont);

        data.append(anggotaBertugas);

        const penindakan = $(`<div class="flex flex-column gap-2" />`);
        const penindakanTitle = $(
          `<div class="flex items-center gap-2 text-abu"><span class="material-symbols-outlined">contract</span><span>Data Penindakan</span></div>`,
        );

        const penindakanCont = $(
          `<div class="flex flex-row flex-wrap gap-2" />`,
        );

        penindakanCont.append(`<div class="flex flex-row gap-1 bg-[#eaeaea] py-1 px-2 rounded-md font-bold w-full">
          <div class="flex-auto">Nama Kantor Satuan Kerja</div>
          <div class="w-[100px] flex-none">Total Kasus</div>
          <div class="w-[165px] flex-none">Total Tangkapan (gr)</div>
        </div>`);

        const penindakanData = $(`<div class="w-full flex flex-column"/>`);

        for (const satker of window.allOffice) {
          if (String(satker.parent_id) !== String(k.id) && satker.id !== k.id)
            continue;

          penindakanData.append(
            `<div class="flex flex-row gap-1 px-2 w-full">
              <div class="border-b-1 border-abu-muda py-1 flex-auto">${satker.shortname}</div>
              <div class="border-b-1 border-abu-muda py-1 w-[100px] flex-none">4567</div>
              <div class="border-b-1 border-abu-muda py-1 w-[165px] flex-none">12345</div>
            </div>`,
          );
        }

        penindakanCont.append(penindakanData);
        penindakan.append(penindakanTitle);
        penindakan.append(penindakanCont);
        data.append(penindakan);

        container.append(data);
        container.addClass("flex gap-4");
        body.append(container);

        $("#modalDetail").modal("show");
      });

    if (anggotaAtKanwilExists(k.id)) {
      cg.circle(18)
        .fill("#e8636d")
        .opacity(0.2)
        .move(x - 9, y - 9);
    }

    cg.circle(8)
      .fill("#e8636d")
      .opacity(0.6)
      .move(x - 4, y - 4);

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
