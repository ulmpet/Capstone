google.load("visualization", "1", {packages:["map"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Lat', 'Long', 'Name'],
        [32.5270, -92.0740, 'UL - Monroe'],
        [32.5274, -92.6470, 'LA Tech University'],
        [37.8700, -122.2590, 'University of California, Berkeley'],
        [43.7046, -72.2887, 'Darthmouth College'],
        [30.2123, -92.0200, 'UL - Lafayette'],
        [41.8750, -87.6581, 'University of Illinois at Chicago']
      ]);

      var options = {showTip: true};
      var map = new google.visualization.Map(document.getElementById('ulocationDemograph'));
      map.draw(data, options);
    };
