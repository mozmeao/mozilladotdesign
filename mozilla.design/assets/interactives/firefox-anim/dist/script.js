(function() {
  var svgElSelector = '#blobs-kLEsZ';

  var svgEl = document.querySelector(svgElSelector);
  var mousePosition = [0, 0];
  var scrollY = 0;

  var classes = [
    'top left', 'top center', 'top right',
    'mid left', 'mid center', 'mid right',
    'bottom left', 'bottom center', 'bottom right'
  ];

  var points;
  initPoints();

  if (window.PointerEvent) {
    svgEl.addEventListener('pointermove', throttle(onPointerMove, 100));
  } else {
    svgEl.addEventListener('mousemove', throttle(onPointerMove, 100));
    svgEl.addEventListener('touchmove', throttle(onPointerMove, 100));
  }

  window.addEventListener('resize', debounce(onResize, 300));

  function onPointerMove(event) {
    mousePosition = [event.clientX, event.clientY];

    var distances = [];

    for (var i = 0; i < points.length; i++) {
      var point = points[i];
      var distance = Math.hypot(point[0] - mousePosition[0], point[1] - mousePosition[1]);
      distances.push(distance);
    }

    var closestPointIndex = distances.indexOf(Math.min.apply(Math, distances));

    svgEl.setAttribute('data-location', classes[closestPointIndex]);
  }

  function onResize(event) {
    initPoints();
  }

  function initPoints() {
    points = [
      [0, 0],                      [window.innerWidth / 2, 0],                      [window.innerWidth, 0],
      [0, window.innerHeight / 2], [window.innerWidth / 2, window.innerHeight / 2], [window.innerWidth, window.innerHeight / 2],
      [0, window.innerHeight],     [window.innerWidth / 2, window.innerHeight],     [window.innerWidth, window.innerHeight]
    ];
  }

  function throttle(callback, limit) {
    var wait = false;
    return function() {
      if (!wait) {
        var context = this;
        var args = arguments;
        callback.apply(context, args);
        wait = true;
        setTimeout(function() {
          wait = false;
        }, limit);
      }
    }
  }

  function debounce(callback, wait) {
    var timeout;
    return function() {
      var context = this;
      var args = arguments;
      var later = function() {
        timeout = null;
      }
      var callNow = !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) callback.apply(context, args);
    }
  }
}())
