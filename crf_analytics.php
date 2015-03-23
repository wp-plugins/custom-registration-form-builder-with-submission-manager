<?php
$path =  plugin_dir_url(__FILE__); $path =  plugin_dir_url(__FILE__); 
?>
<form name="field_list" id="field_list" method="post">
<div class="ucf_pro_banner" style="margin-bottom:0 !important; overflow:visible;">
<a href="admin.php?page=crf_Pro"><img src="<?php echo $path;?>images/Analytics_demo_banner.jpg" /></a></div>
  <div class="crf-main-form" style="margin-top:10px;">
  
    <div class="crf-form-name-heading-Submissions">
      <h1 class="hedding-icon">Form Analytics</h1>
    </div>
    <div class="crf-add-remove-field-submissions crf-new-buttons">
    <div class="crf-add-new-button" style="float:left;">
        <input class="reset-butten" type="submit" name="reset_button" value="RESET" onclick="popup()">
      </div>
      <select name="form_id" id="form_id">
                <option value="2" selected="">Form 1</option>
                <option value="16">Form 2</option>
              </select>
    </div>
  </div>
  <div class="crf-main-sortable">
    <ul id="sortable" class="crf_entries">
            <li class="header rows">
        <div class="cols" style="width:30px;">Sr</div>
        <div class="cols" style="width:140px;">User IP</div>
        <div class="cols" style="width:115px;">Conversion</div>
        <div class="cols" style="width:200px;">Visited On (UTC)</div>
        <div class="cols" style="width:200px;">Submitted On (UTC)</div>
        <div class="cols" style="width:135px;">Filling Time</div>
       <!-- <div class="cols" style="">Browser</div>-->
        
      </li>
        
      <li class="alternate rows">
        <div class="cols" style="width:30px;">1</div>
          <div class="cols" style="width:140px;"><a target="_blank" href="http://www.geoiptool.com/?IP=109.169.61.64">109.169.61.64</a></div>
          <div class="cols" style="Width:115px;"></div>
           <div class="cols" style="width:200px;">2015-03-20 10:11:02</div>
            <div class="cols" style="width:200px;"></div>
            <div class="cols" style="width:135px;"></div>

      </li>
        
      <li class=" rows">
        <div class="cols" style="width:30px;">2</div>
          <div class="cols" style="width:140px;"><a target="_blank" href="http://www.geoiptool.com/?IP=109.169.61.64">109.169.61.64</a></div>
          <div class="cols" style="Width:115px;"><img style="width: 20px !important;height: 20px !important;" class="submitted_icon" src="<?php echo $path; ?>images/right.png" /></div>
           <div class="cols" style="width:200px;">2015-03-20 10:13:26</div>
            <div class="cols" style="width:200px;">2015-03-20 10:13:47</div>
            <div class="cols" style="width:135px;">21</div>

      </li>
        
      <li class="alternate rows">
        <div class="cols" style="width:30px;">3</div>
          <div class="cols" style="width:140px;"><a target="_blank" href="http://www.geoiptool.com/?IP=109.169.61.64">109.169.61.64</a></div>
          <div class="cols" style="Width:115px;"><img style="width: 20px !important;height: 20px !important;" class="submitted_icon" src="<?php echo $path; ?>images/right.png" /></div>
           <div class="cols" style="width:200px;">2015-03-20 10:19:20</div>
            <div class="cols" style="width:200px;">2015-03-20 10:19:45</div>
            <div class="cols" style="width:135px;">25</div>

      </li>
        
      <li class=" rows">
        <div class="cols" style="width:30px;">4</div>
          <div class="cols" style="width:140px;"><a target="_blank" href="http://www.geoiptool.com/?IP=109.169.61.64">109.169.61.64</a></div>
          <div class="cols" style="Width:115px;"></div>
           <div class="cols" style="width:200px;">2015-03-20 10:14:19</div>
            <div class="cols" style="width:200px;"></div>
            <div class="cols" style="width:135px;"></div>

      </li>
        
      <li class="alternate rows">
        <div class="cols" style="width:30px;">5</div>
          <div class="cols" style="width:140px;"><a target="_blank" href="http://www.geoiptool.com/?IP=109.169.61.64">109.169.61.64</a></div>
          <div class="cols" style="Width:115px;"></div>
           <div class="cols" style="width:200px;">2015-03-20 10:13:53</div>
            <div class="cols" style="width:200px;"></div>
            <div class="cols" style="width:135px;"></div>

      </li>
        
      <li class=" rows">
        <div class="cols" style="width:30px;">6</div>
          <div class="cols" style="width:140px;"><a target="_blank" href="http://www.geoiptool.com/?IP=109.169.61.64">109.169.61.64</a></div>
          <div class="cols" style="Width:115px;"></div>
           <div class="cols" style="width:200px;">2015-03-20 10:13:35</div>
            <div class="cols" style="width:200px;"></div>
            <div class="cols" style="width:135px;"></div>

      </li>
      <div class="cler"></div>
    </ul>
      </div>
</form>
<script type="text/javascript">
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
        data.addColumn('string', 'Status');
        data.addColumn('number', 'Total');
        data.addRows([
          ['Success',76 ],
          ['Failure',34]
        ]);
        // Set chart options
        var options = {
		is3D: true,
                       'width':400,
                       'height':300,'colors': ['#a4d36d', '#f48566']};
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<script type="text/javascript">
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart2);
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart2() {
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Browser');
        data.addColumn('number', 'Views');
        data.addRows([
          ['Opera', 49],
          ['Chrome', 32],
		  ['Internet Explorer', 16],
          ['Firefox', 17],
		  ['Safari', 43]
        ]);
        // Set chart options
        var options = {is3D: true,
                       'width':400,
                       'height':300,'colors': ['#a4d36d', '#f48566', '#6fd6f8', '#f86f92', '#b0bec5','#ceb2e3']};
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
<script type="text/javascript">
	
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Browsers", "Success", "Failure"],
        ['Opera', 22,27],
		['Chrome', 15,17],
		['Internet Explorer', 5,11],
		['Firefox', 8,9],
		['Safari', 20,23]
      ]);

      var view = new google.visualization.DataView(data);
      var options = {
        width: 600,
        height: 400,
        bar: {groupWidth: "75%"},
        legend: { position: 'top', maxLines: 3 },
		colors: ['#a4d36d', '#f48566'],
		isStacked: true
      };
      var chart = new google.visualization.BarChart(document.getElementById("crf_barchart_values"));
      chart.draw(view, options);
  }
  </script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["geochart"]});
      google.setOnLoadCallback(drawRegionsMap);
      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Visitors'],
		  ['USA', 90], 
		  ['Canada', 48], 
		  ['England', 30], 
		  ['France', 25], 
		  ['Germany', 11], 
		  ['Spain', 8], 
		  ['Italy', 6], 
		  ['China', 4], 
		  ['India', 5], 
		  ['Japan', 11],
		  ['Australia', 7], 
		  ['Newzealand', 2], 
		  ['Russia', 1], 
		  ['Belgium', 1], 
		  ['Scotland', 2], 
		  ['South Africa', 2], 
		  ['Kenya', 1], 
		  ['Egypt', 1], 
		  ['Pakistan', 1], 
		  ['Brazil', 8] 
        ]);
        var options = {};
        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        chart.draw(data, options);
      }
    </script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["geochart"]});
      google.setOnLoadCallback(drawRegionsMap);
      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Visitors'],
		  ['USA', 60], 
		  ['Canada', 34], 
		  ['England', 22], 
		  ['France', 10], 
		  ['Germany', 10], 
		  ['Spain', 5], 
		  ['Italy', 3], 
		  ['China', 2], 
		  ['India', 2], 
		  ['Japan', 5],
		  ['Australia', 1],  
		  ['Brazil', 5] 
		  
        ]);
        var options = {};
        var chart = new google.visualization.GeoChart(document.getElementById('regions_div2'));
        chart.draw(data, options);
      }
    </script>
    
      
      
	 
<div class="crf-main-form crf-main-form2">
  <div class="charts">
    <div class="main-chat">
    <h1 class="chat-hedding">Conversion %
     <span class="icon"></span>
    </h1>
    <div class="chartdiv" id="chart_div"></div>
    </div>
     <div class="main-chat1">
     <h1 class="chat-hedding">Browsers Used
     <span class="icon"></span></h1>
    <div class="chartdiv1" id="chart_div2"></div>
    </div>
    <div class="cler"></div>
    </div>
    <div class="chartss">
      <div class="success-div">
      <h1>
     <span class="icon"></span>
    </h1>
      <div class="chartdiv">
        <div class="percent_rate"><span class="tex-average">69.1<span class="tex-color1">%</span></span></div>
        <div class="charts_title"><h2>Form Success Rate</h2></div>
      </div>
      </div>
      
      <div class="Time-div">
      <h1>
     <span class="icon"></span>
    </h1>
      <div class="chartdiv">
        <div class="percent_rate oreng"><span class="tex-average">23<span class="tex-color2">s</span></span></div>
        <div class="charts_title"><h2>Average Time</h2></div>
      </div>
      </div>
      
      <div class="cler"></div>
    </div>
    
  <div class="barchart">
  <h1>Browser Based Conversion Comparison<span class="icon"></span></h1>
  <div id="crf_barchart_values"> </div></div>
 
  <div class="regionss">
  <h1>Visitors Map<span class="icon"></span></h1>
  <div id="regions_div"></div></div>
  <div class="regionss">
  <h1>Submissions Map<span class="icon"></span></h1>
  <div id="regions_div2"></div></div>
  
</div>
 
 <div class="crf-main-form crf-main-form2">
 <div class="crf-chart-top">
    <form name="field_list" id="field_list" method="post">
    <div class="crf-form-name-heading-Submissions">
      <h1 class="fieldanalytics-icon">Field Analytics</h1>
    </div>
    <div class="crf-add-remove-field-submissions crf-new-buttons">
      <select name="form_id" id="form_id" onchange="redirectform(this.value)">
                <option value="2" selected="">Form 1</option>
                <option value="16">Form 2</option>
              </select>
      </div>
      
   </form>
   </div>
   <div class="cler"></div>
  	<div class="charts charts-2">
    <div class="charts-main-box">
   
   <script type="text/javascript">
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
		  data.addColumn('string', 'Options');
		  data.addColumn('number', 'Submissions');
		  data.addRows([
		  ['Male', 90],
		  ['Female', 120]
		  
		  ]);
		  // Set chart options
		  var options = {
		  is3D: true,
						 'width':400,
						 'height':300,'colors': ['#a4d36d', '#f48566', '#6fd6f8', '#f86f92', '#b0bec5','#ceb2e3','#ffd851','#6dd3b0','#6dd39b','#c8c6bf']};
		  // Instantiate and draw our chart, passing in some options.
		  var chart = new google.visualization.PieChart(document.getElementById('field_div_sex'));
		  chart.draw(data, options);
		}
	  </script>
      <script type="text/javascript">
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
		  data.addColumn('string', 'Options');
		  data.addColumn('number', 'Submissions');
		  data.addRows([
		  ['Hip Hop', 73],
		  ['Pop', 34],
		  ['Punk', 31],
		  ['Reggae', 60],
		  ['Rap', 56],
		  ['Country', 27],
		  ['Jazz', 22],
		  ['Classical', 90],
		  ['Blues', 45],
		  ['Rock', 116]
		  ]);
		  // Set chart options
		  var options = {
		  is3D: true,
						 'width':400,
						 'height':300,'colors': ['#a4d36d', '#f48566', '#6fd6f8', '#f86f92', '#b0bec5','#ceb2e3','#ffd851','#6dd3b0','#6dd39b','#c8c6bf']};
		  // Instantiate and draw our chart, passing in some options.
		  var chart = new google.visualization.PieChart(document.getElementById('field_div_music'));
		  chart.draw(data, options);
		}
	  </script>
      
      <script type="text/javascript">
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
		  data.addColumn('string', 'Options');
		  data.addColumn('number', 'Submissions');
		  data.addRows([
		  ['OS X', 73],
		  ['Windows 8.1', 34],
		  ['Windows 7', 31],
		  ['Windows Vista', 60],
		  ['Ubuntu', 56],
		  ['Fedora', 27],
		  ['Others', 22]
		  ]);
		  // Set chart options
		  var options = {
		  is3D: true,
						 'width':400,
						 'height':300,'colors': ['#a4d36d', '#f48566', '#6fd6f8', '#f86f92', '#b0bec5','#ceb2e3','#ffd851','#6dd3b0','#6dd39b','#c8c6bf']};
		  // Instantiate and draw our chart, passing in some options.
		  var chart = new google.visualization.PieChart(document.getElementById('field_div_os'));
		  chart.draw(data, options);
		}
	  </script>
      
      <script type="text/javascript">
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
		  data.addColumn('string', 'Options');
		  data.addColumn('number', 'Submissions');
		  data.addRows([
		  ['Xbox One', 73],
		  ['PS4', 34],
		  ['Wii U', 31],
		  ['PC ftw!!', 60]
		  ]);
		  // Set chart options
		  var options = {
		  is3D: true,
						 'width':400,
						 'height':300,'colors': ['#a4d36d', '#f48566', '#6fd6f8', '#f86f92', '#b0bec5','#ceb2e3','#ffd851','#6dd3b0','#6dd39b','#c8c6bf']};
		  // Instantiate and draw our chart, passing in some options.
		  var chart = new google.visualization.PieChart(document.getElementById('field_div_game'));
		  chart.draw(data, options);
		}
	  </script>
      
	  <div class="main-chat crf_main_chart_odd">
	  <h1 class="chat-hedding">Sex<span class="icon"></span></h1>
	  <div class="chartdiv" id="field_div_sex"></div>
	  </div>
      
      <div class="main-chat crf_main_chart_even">
	  <h1 class="chat-hedding">Preferred Music Genre<span class="icon"></span></h1>
	  <div class="chartdiv" id="field_div_music"></div>
	  </div>
      
      <div class="main-chat crf_main_chart_odd">
	  <h1 class="chat-hedding">Your Preferred Desktop OS<span class="icon"></span></h1>
	  <div class="chartdiv" id="field_div_os"></div>
	  </div>
      
      <div class="main-chat crf_main_chart_even">
	  <h1 class="chat-hedding">Your Favorite Next-Gen Console<span class="icon"></span></h1>
	  <div class="chartdiv" id="field_div_game"></div>
	  </div>
      
   </div>
   </div>
   </div>
 
<style>
img.submitted_icon{ width: 20px !important; margin-left:40px;
height: 20px !important;
border: none !important;}
</style>