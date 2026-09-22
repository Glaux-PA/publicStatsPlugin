Third-party libraries bundled in this folder.

| File | Library | Version | License | Source |
| --- | --- | --- | --- | --- |
| chart.min.js | Chart.js | 4.5.1 | MIT | https://github.com/chartjs/Chart.js/releases/tag/v4.5.1 |
| chartjs-plugin-zoom.min.js | chartjs-plugin-zoom | 2.0.1 | MIT | https://github.com/chartjs/chartjs-plugin-zoom/releases/tag/v2.0.1 |
| hammer.min.js | Hammer.JS | 2.0.7 | MIT | https://github.com/hammerjs/hammer.js/releases/tag/v2.0.7 |
| leaflet.js | Leaflet | 1.9.4 | BSD-2-Clause | https://github.com/Leaflet/Leaflet/releases/tag/v1.9.4 |

Versions are the ones in each file's own header banner.

Notes:

- Hammer.JS is a dependency of chartjs-plugin-zoom, used only for pinch zoom
  and touch pan on the charts. The plugin loads it if present and works
  without it, losing those gestures on touch devices. It was released in 2016
  and the project is archived, so it should be reviewed whenever
  chartjs-plugin-zoom is updated.
- hammer.min.js has to be loaded before chartjs-plugin-zoom.min.js. See
  setupAssets() in controllers/PublicStatisticsHandler.php.
- The stylesheets and fonts are listed in templates/styles/vendor/VERSIONS.md.
