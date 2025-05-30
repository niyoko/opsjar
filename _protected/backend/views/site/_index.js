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
    g.path(p.path_data).fill(p.background_color).stroke("#474f7d");
  }

  const gKanwil = gMain.group();
  for (const k of window.dataKanwil) {
    const { x, y } = convertCoordinate(k.coordinate);
    const cg = gKanwil
      .group()
      .css("cursor", "pointer")
      .data("toggle", "popover")
      .data("bs-title", k.shortname)
      .data("bs-placement", "bottom")
      .data("bs-content", "contoh <b>Content</b>")
      .on("click", function () {
        console.log(k);
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
