(function () {
	'use strict';

	function getDefaultExportFromCjs (x) {
		return x && x.__esModule && Object.prototype.hasOwnProperty.call(x, 'default') ? x['default'] : x;
	}

	function getAugmentedNamespace(n) {
	  if (Object.prototype.hasOwnProperty.call(n, '__esModule')) return n;
	  var f = n.default;
		if (typeof f == "function") {
			var a = function a () {
				if (this instanceof a) {
	        return Reflect.construct(f, arguments, this.constructor);
				}
				return f.apply(this, arguments);
			};
			a.prototype = f.prototype;
	  } else a = {};
	  Object.defineProperty(a, '__esModule', {value: true});
		Object.keys(n).forEach(function (k) {
			var d = Object.getOwnPropertyDescriptor(n, k);
			Object.defineProperty(a, k, d.get ? d : {
				enumerable: true,
				get: function () {
					return n[k];
				}
			});
		});
		return a;
	}

	var parseSvgPath;
	var hasRequiredParseSvgPath;
	function requireParseSvgPath() {
	  if (hasRequiredParseSvgPath) return parseSvgPath;
	  hasRequiredParseSvgPath = 1;
	  parseSvgPath = parse;

	  /**
	   * expected argument lengths
	   * @type {Object}
	   */

	  var length = {
	    a: 7,
	    c: 6,
	    h: 1,
	    l: 2,
	    m: 2,
	    q: 4,
	    s: 4,
	    t: 2,
	    v: 1,
	    z: 0
	  };

	  /**
	   * segment pattern
	   * @type {RegExp}
	   */

	  var segment = /([astvzqmhlc])([^astvzqmhlc]*)/ig;

	  /**
	   * parse an svg path data string. Generates an Array
	   * of commands where each command is an Array of the
	   * form `[command, arg1, arg2, ...]`
	   *
	   * @param {String} path
	   * @return {Array}
	   */

	  function parse(path) {
	    var data = [];
	    path.replace(segment, function (_, command, args) {
	      var type = command.toLowerCase();
	      args = parseValues(args);

	      // overloaded moveTo
	      if (type == 'm' && args.length > 2) {
	        data.push([command].concat(args.splice(0, 2)));
	        type = 'l';
	        command = command == 'm' ? 'l' : 'L';
	      }
	      while (true) {
	        if (args.length == length[type]) {
	          args.unshift(command);
	          return data.push(args);
	        }
	        if (args.length < length[type]) throw new Error('malformed path data');
	        data.push([command].concat(args.splice(0, length[type])));
	      }
	    });
	    return data;
	  }
	  var number = /-?[0-9]*\.?[0-9]+(?:e[-+]?\d+)?/ig;
	  function parseValues(args) {
	    var numbers = args.match(number);
	    return numbers ? numbers.map(Number) : [];
	  }
	  return parseSvgPath;
	}

	var absSvgPath;
	var hasRequiredAbsSvgPath;
	function requireAbsSvgPath() {
	  if (hasRequiredAbsSvgPath) return absSvgPath;
	  hasRequiredAbsSvgPath = 1;
	  absSvgPath = absolutize;

	  /**
	   * redefine `path` with absolute coordinates
	   *
	   * @param {Array} path
	   * @return {Array}
	   */

	  function absolutize(path) {
	    var startX = 0;
	    var startY = 0;
	    var x = 0;
	    var y = 0;
	    return path.map(function (seg) {
	      seg = seg.slice();
	      var type = seg[0];
	      var command = type.toUpperCase();

	      // is relative
	      if (type != command) {
	        seg[0] = command;
	        switch (type) {
	          case 'a':
	            seg[6] += x;
	            seg[7] += y;
	            break;
	          case 'v':
	            seg[1] += y;
	            break;
	          case 'h':
	            seg[1] += x;
	            break;
	          default:
	            for (var i = 1; i < seg.length;) {
	              seg[i++] += x;
	              seg[i++] += y;
	            }
	        }
	      }

	      // update cursor state
	      switch (command) {
	        case 'Z':
	          x = startX;
	          y = startY;
	          break;
	        case 'H':
	          x = seg[1];
	          break;
	        case 'V':
	          y = seg[1];
	          break;
	        case 'M':
	          x = startX = seg[1];
	          y = startY = seg[2];
	          break;
	        default:
	          x = seg[seg.length - 2];
	          y = seg[seg.length - 1];
	      }
	      return seg;
	    });
	  }
	  return absSvgPath;
	}

	var _slicedToArray = function () {
	  function sliceIterator(arr, i) {
	    var _arr = [];
	    var _n = true;
	    var _d = false;
	    var _e = undefined;
	    try {
	      for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
	        _arr.push(_s.value);
	        if (i && _arr.length === i) break;
	      }
	    } catch (err) {
	      _d = true;
	      _e = err;
	    } finally {
	      try {
	        if (!_n && _i["return"]) _i["return"]();
	      } finally {
	        if (_d) throw _e;
	      }
	    }
	    return _arr;
	  }
	  return function (arr, i) {
	    if (Array.isArray(arr)) {
	      return arr;
	    } else if (Symbol.iterator in Object(arr)) {
	      return sliceIterator(arr, i);
	    } else {
	      throw new TypeError("Invalid attempt to destructure non-iterable instance");
	    }
	  };
	}();
	var TAU = Math.PI * 2;
	var mapToEllipse = function mapToEllipse(_ref, rx, ry, cosphi, sinphi, centerx, centery) {
	  var x = _ref.x,
	    y = _ref.y;
	  x *= rx;
	  y *= ry;
	  var xp = cosphi * x - sinphi * y;
	  var yp = sinphi * x + cosphi * y;
	  return {
	    x: xp + centerx,
	    y: yp + centery
	  };
	};
	var approxUnitArc = function approxUnitArc(ang1, ang2) {
	  // If 90 degree circular arc, use a constant
	  // as derived from http://spencermortensen.com/articles/bezier-circle
	  var a = ang2 === 1.5707963267948966 ? 0.551915024494 : ang2 === -1.5707963267948966 ? -0.551915024494 : 4 / 3 * Math.tan(ang2 / 4);
	  var x1 = Math.cos(ang1);
	  var y1 = Math.sin(ang1);
	  var x2 = Math.cos(ang1 + ang2);
	  var y2 = Math.sin(ang1 + ang2);
	  return [{
	    x: x1 - y1 * a,
	    y: y1 + x1 * a
	  }, {
	    x: x2 + y2 * a,
	    y: y2 - x2 * a
	  }, {
	    x: x2,
	    y: y2
	  }];
	};
	var vectorAngle = function vectorAngle(ux, uy, vx, vy) {
	  var sign = ux * vy - uy * vx < 0 ? -1 : 1;
	  var dot = ux * vx + uy * vy;
	  if (dot > 1) {
	    dot = 1;
	  }
	  if (dot < -1) {
	    dot = -1;
	  }
	  return sign * Math.acos(dot);
	};
	var getArcCenter = function getArcCenter(px, py, cx, cy, rx, ry, largeArcFlag, sweepFlag, sinphi, cosphi, pxp, pyp) {
	  var rxsq = Math.pow(rx, 2);
	  var rysq = Math.pow(ry, 2);
	  var pxpsq = Math.pow(pxp, 2);
	  var pypsq = Math.pow(pyp, 2);
	  var radicant = rxsq * rysq - rxsq * pypsq - rysq * pxpsq;
	  if (radicant < 0) {
	    radicant = 0;
	  }
	  radicant /= rxsq * pypsq + rysq * pxpsq;
	  radicant = Math.sqrt(radicant) * (largeArcFlag === sweepFlag ? -1 : 1);
	  var centerxp = radicant * rx / ry * pyp;
	  var centeryp = radicant * -ry / rx * pxp;
	  var centerx = cosphi * centerxp - sinphi * centeryp + (px + cx) / 2;
	  var centery = sinphi * centerxp + cosphi * centeryp + (py + cy) / 2;
	  var vx1 = (pxp - centerxp) / rx;
	  var vy1 = (pyp - centeryp) / ry;
	  var vx2 = (-pxp - centerxp) / rx;
	  var vy2 = (-pyp - centeryp) / ry;
	  var ang1 = vectorAngle(1, 0, vx1, vy1);
	  var ang2 = vectorAngle(vx1, vy1, vx2, vy2);
	  if (sweepFlag === 0 && ang2 > 0) {
	    ang2 -= TAU;
	  }
	  if (sweepFlag === 1 && ang2 < 0) {
	    ang2 += TAU;
	  }
	  return [centerx, centery, ang1, ang2];
	};
	var arcToBezier = function arcToBezier(_ref2) {
	  var px = _ref2.px,
	    py = _ref2.py,
	    cx = _ref2.cx,
	    cy = _ref2.cy,
	    rx = _ref2.rx,
	    ry = _ref2.ry,
	    _ref2$xAxisRotation = _ref2.xAxisRotation,
	    xAxisRotation = _ref2$xAxisRotation === undefined ? 0 : _ref2$xAxisRotation,
	    _ref2$largeArcFlag = _ref2.largeArcFlag,
	    largeArcFlag = _ref2$largeArcFlag === undefined ? 0 : _ref2$largeArcFlag,
	    _ref2$sweepFlag = _ref2.sweepFlag,
	    sweepFlag = _ref2$sweepFlag === undefined ? 0 : _ref2$sweepFlag;
	  var curves = [];
	  if (rx === 0 || ry === 0) {
	    return [];
	  }
	  var sinphi = Math.sin(xAxisRotation * TAU / 360);
	  var cosphi = Math.cos(xAxisRotation * TAU / 360);
	  var pxp = cosphi * (px - cx) / 2 + sinphi * (py - cy) / 2;
	  var pyp = -sinphi * (px - cx) / 2 + cosphi * (py - cy) / 2;
	  if (pxp === 0 && pyp === 0) {
	    return [];
	  }
	  rx = Math.abs(rx);
	  ry = Math.abs(ry);
	  var lambda = Math.pow(pxp, 2) / Math.pow(rx, 2) + Math.pow(pyp, 2) / Math.pow(ry, 2);
	  if (lambda > 1) {
	    rx *= Math.sqrt(lambda);
	    ry *= Math.sqrt(lambda);
	  }
	  var _getArcCenter = getArcCenter(px, py, cx, cy, rx, ry, largeArcFlag, sweepFlag, sinphi, cosphi, pxp, pyp),
	    _getArcCenter2 = _slicedToArray(_getArcCenter, 4),
	    centerx = _getArcCenter2[0],
	    centery = _getArcCenter2[1],
	    ang1 = _getArcCenter2[2],
	    ang2 = _getArcCenter2[3];

	  // If 'ang2' == 90.0000000001, then `ratio` will evaluate to
	  // 1.0000000001. This causes `segments` to be greater than one, which is an
	  // unecessary split, and adds extra points to the bezier curve. To alleviate
	  // this issue, we round to 1.0 when the ratio is close to 1.0.

	  var ratio = Math.abs(ang2) / (TAU / 4);
	  if (Math.abs(1.0 - ratio) < 0.0000001) {
	    ratio = 1.0;
	  }
	  var segments = Math.max(Math.ceil(ratio), 1);
	  ang2 /= segments;
	  for (var i = 0; i < segments; i++) {
	    curves.push(approxUnitArc(ang1, ang2));
	    ang1 += ang2;
	  }
	  return curves.map(function (curve) {
	    var _mapToEllipse = mapToEllipse(curve[0], rx, ry, cosphi, sinphi, centerx, centery),
	      x1 = _mapToEllipse.x,
	      y1 = _mapToEllipse.y;
	    var _mapToEllipse2 = mapToEllipse(curve[1], rx, ry, cosphi, sinphi, centerx, centery),
	      x2 = _mapToEllipse2.x,
	      y2 = _mapToEllipse2.y;
	    var _mapToEllipse3 = mapToEllipse(curve[2], rx, ry, cosphi, sinphi, centerx, centery),
	      x = _mapToEllipse3.x,
	      y = _mapToEllipse3.y;
	    return {
	      x1: x1,
	      y1: y1,
	      x2: x2,
	      y2: y2,
	      x: x,
	      y: y
	    };
	  });
	};

	var modules = /*#__PURE__*/Object.freeze({
		__proto__: null,
		default: arcToBezier
	});

	var require$$0 = /*@__PURE__*/getAugmentedNamespace(modules);

	var normalizeSvgPath;
	var hasRequiredNormalizeSvgPath;
	function requireNormalizeSvgPath() {
	  if (hasRequiredNormalizeSvgPath) return normalizeSvgPath;
	  hasRequiredNormalizeSvgPath = 1;
	  normalizeSvgPath = normalize;
	  var arcToCurve = require$$0;
	  function normalize(path) {
	    // init state
	    var prev;
	    var result = [];
	    var bezierX = 0;
	    var bezierY = 0;
	    var startX = 0;
	    var startY = 0;
	    var quadX = null;
	    var quadY = null;
	    var x = 0;
	    var y = 0;
	    for (var i = 0, len = path.length; i < len; i++) {
	      var seg = path[i];
	      var command = seg[0];
	      switch (command) {
	        case 'M':
	          startX = seg[1];
	          startY = seg[2];
	          break;
	        case 'A':
	          var curves = arcToCurve({
	            px: x,
	            py: y,
	            cx: seg[6],
	            cy: seg[7],
	            rx: seg[1],
	            ry: seg[2],
	            xAxisRotation: seg[3],
	            largeArcFlag: seg[4],
	            sweepFlag: seg[5]
	          });

	          // null-curves
	          if (!curves.length) continue;
	          for (var j = 0, c; j < curves.length; j++) {
	            c = curves[j];
	            seg = ['C', c.x1, c.y1, c.x2, c.y2, c.x, c.y];
	            if (j < curves.length - 1) result.push(seg);
	          }
	          break;
	        case 'S':
	          // default control point
	          var cx = x;
	          var cy = y;
	          if (prev == 'C' || prev == 'S') {
	            cx += cx - bezierX; // reflect the previous command's control
	            cy += cy - bezierY; // point relative to the current point
	          }
	          seg = ['C', cx, cy, seg[1], seg[2], seg[3], seg[4]];
	          break;
	        case 'T':
	          if (prev == 'Q' || prev == 'T') {
	            quadX = x * 2 - quadX; // as with 'S' reflect previous control point
	            quadY = y * 2 - quadY;
	          } else {
	            quadX = x;
	            quadY = y;
	          }
	          seg = quadratic(x, y, quadX, quadY, seg[1], seg[2]);
	          break;
	        case 'Q':
	          quadX = seg[1];
	          quadY = seg[2];
	          seg = quadratic(x, y, seg[1], seg[2], seg[3], seg[4]);
	          break;
	        case 'L':
	          seg = line(x, y, seg[1], seg[2]);
	          break;
	        case 'H':
	          seg = line(x, y, seg[1], y);
	          break;
	        case 'V':
	          seg = line(x, y, x, seg[1]);
	          break;
	        case 'Z':
	          seg = line(x, y, startX, startY);
	          break;
	      }

	      // update state
	      prev = command;
	      x = seg[seg.length - 2];
	      y = seg[seg.length - 1];
	      if (seg.length > 4) {
	        bezierX = seg[seg.length - 4];
	        bezierY = seg[seg.length - 3];
	      } else {
	        bezierX = x;
	        bezierY = y;
	      }
	      result.push(seg);
	    }
	    return result;
	  }
	  function line(x1, y1, x2, y2) {
	    return ['C', x1, y1, x2, y2, x2, y2];
	  }
	  function quadratic(x1, y1, cx, cy, x2, y2) {
	    return ['C', x1 / 3 + 2 / 3 * cx, y1 / 3 + 2 / 3 * cy, x2 / 3 + 2 / 3 * cx, y2 / 3 + 2 / 3 * cy, x2, y2];
	  }
	  return normalizeSvgPath;
	}

	var isSvgPath;
	var hasRequiredIsSvgPath;
	function requireIsSvgPath() {
	  if (hasRequiredIsSvgPath) return isSvgPath;
	  hasRequiredIsSvgPath = 1;
	  isSvgPath = function isPath(str) {
	    if (typeof str !== 'string') return false;
	    str = str.trim();

	    // https://www.w3.org/TR/SVG/paths.html#PathDataBNF
	    if (/^[mzlhvcsqta]\s*[-+.0-9][^mlhvzcsqta]+/i.test(str) && /[\dz]$/i.test(str) && str.length > 4) return true;
	    return false;
	  };
	  return isSvgPath;
	}

	var svgPathBounds;
	var hasRequiredSvgPathBounds;
	function requireSvgPathBounds() {
	  if (hasRequiredSvgPathBounds) return svgPathBounds;
	  hasRequiredSvgPathBounds = 1;
	  var parse = requireParseSvgPath();
	  var abs = requireAbsSvgPath();
	  var normalize = requireNormalizeSvgPath();
	  var isSvgPath = requireIsSvgPath();
	  svgPathBounds = pathBounds;
	  function pathBounds(path) {
	    // ES6 string tpl call
	    if (Array.isArray(path) && path.length === 1 && typeof path[0] === 'string') path = path[0];

	    // svg path string
	    if (typeof path === 'string') {
	      if (!isSvgPath(path)) throw Error('String is not an SVG path.');
	      path = parse(path);
	    }
	    if (!Array.isArray(path)) throw Error('Argument should be a string or an array of path segments.');
	    path = abs(path);
	    path = normalize(path);
	    if (!path.length) return [0, 0, 0, 0];
	    var bounds = [Infinity, Infinity, -Infinity, -Infinity];
	    for (var i = 0, l = path.length; i < l; i++) {
	      var points = path[i].slice(1);
	      for (var j = 0; j < points.length; j += 2) {
	        if (points[j + 0] < bounds[0]) bounds[0] = points[j + 0];
	        if (points[j + 1] < bounds[1]) bounds[1] = points[j + 1];
	        if (points[j + 0] > bounds[2]) bounds[2] = points[j + 0];
	        if (points[j + 1] > bounds[3]) bounds[3] = points[j + 1];
	      }
	    }
	    return bounds;
	  }
	  return svgPathBounds;
	}

	var svgPathBoundsExports = requireSvgPathBounds();
	var getBounds = /*@__PURE__*/getDefaultExportFromCjs(svgPathBoundsExports);

	var normalizeSvgCoords;
	var hasRequiredNormalizeSvgCoords;
	function requireNormalizeSvgCoords() {
	  if (hasRequiredNormalizeSvgCoords) return normalizeSvgCoords;
	  hasRequiredNormalizeSvgCoords = 1;
	  const parse = requireParseSvgPath();
	  const getBounds = requireSvgPathBounds();

	  // Taken from the SVG specification: https://www.w3.org/TR/SVG/paths.html
	  // Uppercase instructions refer to absolute coordinates whilst lowercase
	  // instructions use coordinates relative to the last instruction.
	  const INSTRUCTIONS = ['M', 'm', 'L', 'l', 'H', 'h', 'V', 'v', 'C', 'c', 'S', 's', 'Q', 'q', 'T', 't', 'A', 'a', 'Z', 'z'];
	  const XMIN = 0;
	  const YMIN = 1;
	  const XMAX = 2;
	  const YMAX = 3;

	  // The viewBox string may be specified using spaces or commas as delimiters.
	  // The order is: xmin, ymin, xmax, ymax
	  const extractViewBox = function (viewBoxStr) {
	    const parts = viewBoxStr.split(/\s*,\s*|\s+/);
	    return [parseFloat(parts[0]), parseFloat(parts[1]), parseFloat(parts[2]), parseFloat(parts[3])];
	  };

	  // Normalize an SVG path to between a specified min and max.
	  // Throws an error on invalid parameters.
	  const normalize = function ({
	    viewBox,
	    path,
	    min = 0,
	    max = 1,
	    precision = 4,
	    asList
	  }) {
	    let bounds;
	    switch (typeof viewBox) {
	      case 'string':
	        bounds = extractViewBox(viewBox);
	        break;
	      case 'object':
	        bounds = viewBox;
	        if (!Array.isArray(bounds)) {
	          bounds = [bounds.xmin, bounds.ymin, bounds.xmax, bounds.ymax];
	        }
	        break;
	      case 'undefined':
	        bounds = getBounds(path);
	        break;
	      default:
	        throw Error('Unknown viewBox format');
	    }
	    const normalized = parse(path).map(feature => {
	      const instruction = feature[0];
	      if (INSTRUCTIONS.indexOf(instruction) === -1) {
	        throw Error(`Unknown instruction ${instruction} in path`);
	      }
	      const remaining = feature.slice(1);

	      // Transform into IR
	      let intermediates = [];
	      if (instruction === 'A' || instruction === 'a') {
	        const [rx, ry, xrot, largearc, sweep, x, y] = remaining;
	        intermediates = [{
	          value: rx,
	          x: true
	        }, {
	          value: ry
	        }, {
	          value: xrot,
	          skip: true
	        }, {
	          value: largearc,
	          skip: true
	        }, {
	          value: sweep,
	          skip: true
	        }, {
	          value: x,
	          x: true
	        }, {
	          value: y
	        }];
	      } else if (instruction === 'H' || instruction === 'h') {
	        const [xplus] = remaining;
	        intermediates = [{
	          value: xplus,
	          x: true
	        }];
	      } else if (instruction === 'V' || instruction === 'v') {
	        const [yplus] = remaining;
	        intermediates = [{
	          value: yplus
	        }];
	      } else {
	        // X coordinates are at even positions whilst Y coordinates are at odd.
	        intermediates = remaining.map((value, i) => ({
	          value,
	          x: i % 2 === 0
	        }));
	      }

	      // Normalize the values of each coordinate.
	      const coords = intermediates.reduce((processed, {
	        value,
	        skip,
	        x
	      }) => {
	        if (skip) {
	          return processed.concat(value);
	        }
	        const norm = normalizeCoord({
	          value,
	          min,
	          max,
	          bounds,
	          x
	        }).toFixed(precision);
	        return processed.concat(norm);
	      }, []);

	      // Return as segmented list?
	      if (asList) {
	        coords.unshift(instruction);
	        return coords;
	      }
	      return instruction + coords.join(' ');
	    });
	    return asList ? normalized : normalized.join('');
	  };
	  const normalizeCoord = function ({
	    value,
	    x,
	    bounds,
	    min,
	    max
	  }) {
	    const float = parseFloat(value);
	    if (isNaN(float)) {
	      throw Error(`Invalid coordinate ${value} in path`);
	    }
	    const oldMax = x ? bounds[XMAX] : bounds[YMAX];
	    const oldMin = x ? bounds[XMIN] : bounds[YMIN];
	    return scale(max, min, oldMax, oldMin, float);
	  };

	  // Scale a value in range [oldMin, oldMax] to the scale
	  // [newMin, newMax].
	  // See https://stackoverflow.com/a/5295202/6413814
	  const scale = function (newMax, newMin, oldMax, oldMin, x) {
	    const scalar = newMax - newMin;
	    const diff = oldMax - oldMin;
	    if (diff == 0) {
	      return newMin;
	    }
	    return scalar * (x - oldMin) / diff + newMin;
	  };
	  normalizeSvgCoords = normalize;
	  return normalizeSvgCoords;
	}

	var normalizeSvgCoordsExports = requireNormalizeSvgCoords();
	var normalize = /*@__PURE__*/getDefaultExportFromCjs(normalizeSvgCoordsExports);

	window.getBounds = getBounds;
	window.normalizePath = normalize;

})();
