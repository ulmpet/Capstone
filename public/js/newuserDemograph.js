      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Time Frame');
        data.addColumn('number', 'New Users');
        data.addRows([
          ['Week 1', 5],
          ['Week 2', 2],
          ['Week 3', 7],
          ['Week 4', 3],          
        ]);

        // Set chart options
        var options = {'title':'New User Registrations',
                       'width':500,
                       'height':400};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.AreaChart(document.getElementById('newuserDemograph'));
        chart.draw(data, options);
      };