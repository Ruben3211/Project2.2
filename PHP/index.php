<!DOCTYPE html>
<html>
<head style="background-color:white;">

  <?php
  include('include.php');
  $row = 1;
if (($handle = fopen("statfra.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        for ($c=0; $c < $num; $c++) {
          $plaats = strtoupper($_GET["name"]);
          $arr = explode(";", $data[0]);
          if($plaats == $arr[0]){
            $nummer = explode(";", $data[$c]);
            $_SESSION["name"] = $nummer[0];
            $_SESSION["stn"] = $nummer[1];
            $_SESSION["country"] = $nummer[2];
            $_SESSION["lati"] = $nummer[3];
            $_SESSION["long"] = $nummer[4];
            $_SESSION["alt"] = $nummer[5];
        }
    }
}
    fclose($handle);
}
?>
<script>
  myButton.onclick=function(e){
    e.preventDefault();
    return false;
}
</script>


<div class="row">
  <div class="leftcolumn">
      <div class="card">
        <input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Search for a place.." title="Type in a name">
          <div class="vertical-menu">
          <ul id="myUL">
<?php
                for($x = 0; $x < $_SESSION['get']; $x++){
?>
                <title><?php echo ucwords(strtolower($_GET["name"])); ?></title><li><a href="index.php?name=<?php echo $_SESSION['city'][$x]; ?>" class="<?php if(strtoupper($_GET["name"]) == strtoupper($_SESSION['city'][$x])){ echo "active";} else{ echo "passive"; } ?>">

<?php
                echo $_SESSION['city'][$x];
?>
                </a></li>

<?php
}
?>
</ul>
          </div>
            </div>
          </div>
<?php

$files = glob("Data/*xml");

if (is_array($files)) {

     foreach($files as $filename) {
        $xml_file = simplexml_load_file($filename) or die("Error: Cannot create object");
        foreach($xml_file->children() as $ja){
          if($ja->STN == $_SESSION['stn']){
            $xas[] = $ja->TIME;
            $wdspyas[] = $ja->WDSP;
            $stpyas[] = $ja->STP;
            $wnddiryas[] = $ja->WNDDIR;
            $date[] = $ja->DATE;
          }
        }
     }
}

if(!empty($xas)){
  $rxas = array_reverse($xas);
  $wdspryas = array_reverse($wdspyas);
  $stpryas = array_reverse($stpyas);
  $wnddirryas = array_reverse($wnddiryas);
  $date = array_reverse($date);


if(!isset($_SESSION["date"]) AND count($_SESSION["date"]) <= count($date)) {
  for($x = 0; $x < count($date); $x++){
      $_SESSION["date"][] = $date[$x] . "";
      $_SESSION["xas"][] = $rxas[$x] . "";
      $_SESSION["wdsp"][] = $wdspryas[$x] . "";
      $_SESSION["stp"][] = $stpryas[$x] . "";
      $_SESSION["wnddir"][] = $wnddirryas[$x] . "";
  } 
  } elseif($_GET["name"] != $_SESSION["tempname"]) {
      unset($_SESSION["date"]);
      unset($_SESSION["xas"]);
      unset($_SESSION["wdsp"]);
      unset($_SESSION["stp"]);
      unset($_SESSION["wnddir"]);
        for($x = 0; $x < count($date); $x++){
          $_SESSION["date"][] = $date[$x] . "";
          $_SESSION["xas"][] = $rxas[$x] . "";
          $_SESSION["wdsp"][] = $wdspryas[$x] . "";
          $_SESSION["stp"][] = $stpryas[$x] . "";
          $_SESSION["wnddir"][] = $wnddirryas[$x] . "";
  } 
}

  if(count($xas) > 59){
    for($x = 0; $x < 60; $x++){
      $fxas[] = $rxas[$x];
      $wdspfyas[] = $wdspryas[$x];
      $stpfyas[] = $stpryas[$x];
      $wnddirfyas[] = $wnddirryas[$x];
    }
  } else {
    for($x = 0; $x < count($xas); $x++){
      $fxas[] = $rxas[$x];
      $wdspfyas[] = $wdspryas[$x];
      $stpfyas[] = $stpryas[$x];
      $wnddirfyas[] = $wnddirryas[$x];
    }
  }

  $rfxas = array_reverse($fxas);
  $wdsprfyas = array_reverse($wdspfyas);
  $stprfyas = array_reverse($stpfyas);
  $wnddirrfyas = array_reverse($wnddirfyas);
}
?>
  <div class="rightcolumn">
      
      <div class="h2" style="margin-top: 40px;"><?php echo ucwords(strtolower($_SESSION["name"])); ?></div>
    <body onload="initialize_map(); add_map_point(<?php echo $_SESSION["lati"]; ?>, <?php echo $_SESSION["long"]; ?>);"></body>
  <div id="map" style="width: 100%; height: 250px;"></div>

  <h3 id="livedata" style="background-color: #0761aa; padding: 10px; color: white;">Live data</h3>
  <?php
  if(!empty($xas)){
  ?>
  <table>
    <tr>
      <th>Date</th>
      <th>Time</th>
      <th>Windspeed in km/h</th>
      <th>Air pressure in mbar</th>
      <th>Wind direction</th>     
    </tr>
    <?php for($x = 0; $x < 4; $x++){
      ?>
    <tr>
      <td><?php echo date("d-m-Y", strtotime($date[$x])); ?></td>
      <td><?php echo $fxas[$x]; ?></td>
      <td><?php echo $wdspfyas[$x]; ?></td>
      <td><?php echo $stpfyas[$x]; ?></td>
      <td><?php
      switch($wnddirfyas[$x]){
        case $wnddirfyas[$x] >= 0.00 && $wnddirfyas[$x] <= 11.25:
          echo "North";
          break;
        case $wnddirfyas[$x] >= 11.25 && $wnddirfyas[$x] <= 33.75:
          echo "North-northeast";
          break;
        case $wnddirfyas[$x] >= 33.75 && $wnddirfyas[$x] <= 56.25:
          echo "North-east";
          break;
        case $wnddirfyas[$x] >= 56.25 && $wnddirfyas[$x] <= 78.75:
          echo "East-northeast";
          break;
        case $wnddirfyas[$x] >= 78.75 && $wnddirfyas[$x] <= 101.25:
          echo "East";
          break;
        case $wnddirfyas[$x] >= 101.25 && $wnddirfyas[$x] <= 123.75:
          echo "East-southeast";
          break;
        case $wnddirfyas[$x] >= 123.75 && $wnddirfyas[$x] <= 146.25:
          echo "South-east";
          break;
        case $wnddirfyas[$x] >= 146.25 && $wnddirfyas[$x] <= 168.75:
          echo "South-southeast";
          break;
        case $wnddirfyas[$x] >= 168.75 && $wnddirfyas[$x] <= 191.25:
          echo "South";
          break;
        case $wnddirfyas[$x] >= 191.25 && $wnddirfyas[$x] <= 213.75:
          echo "South-southwest";
          break;
        case $wnddirfyas[$x] >= 213.75 && $wnddirfyas[$x] <= 236.25:
          echo "South-west";
          break;
        case $wnddirfyas[$x] >= 236.25 && $wnddirfyas[$x] <= 258.75:
          echo "West-southwest";
          break;
        case $wnddirfyas[$x] >= 258.75 && $wnddirfyas[$x] <= 281.25:
          echo "West";
          break;
        case $wnddirfyas[$x] >= 281.25 && $wnddirfyas[$x] <= 303.75:
          echo "West-northwest";
          break;
        case $wnddirfyas[$x] >= 303.75 && $wnddirfyas[$x] <= 326.25:
          echo "North-west";
          break;
        case $wnddirfyas[$x] >= 326.25 && $wnddirfyas[$x] <= 348.75:
          echo "North-northwest";
          break;
        case $wnddirfyas[$x] >= 348.75 && $wnddirfyas[$x] <= 360.00:
          echo "North";
          break;
        default:
          echo "werkt niet";
      } 
          ?>
        </td>
    </tr>
  <?php } ?>
  <tr>
    <td colspan="5"><input class="buttonlive" type="button" onClick="history.go(0)" value="Refresh"></button></td>
  </tr>
  <tr>
    <td colspan="5"><a class="buttondata" href="viewdata.php">View all data</a></td>
  </tr>
</table>

<?php
if(!empty($_GET["name"])){
  $_SESSION["currname"] = $_GET["name"];
}
} else {
    echo "<p>No data available</p>";
}
?></p>
<div class="rightleftcolumn">

      <h3 style="background-color: #0761aa; padding: 10px; color: white;">Windspeed</h3>
    <canvas id="myChart" width="100%" height="75px"></canvas>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
  // The type of chart we want to create
  type: 'line', // also try bar or other graph types

  // The data for our dataset
  data: {
    labels: [<?php for($x = 0; $x < count($wdsprfyas); $x++) { echo "'" . $rfxas[$x] . "',"; } ?>],
    // Information about the dataset
    datasets: [{
      label: "km/h",
      backgroundColor: 'lightblue',
      borderColor: 'royalblue',
      data: [<?php for($x = 0; $x < count($wdsprfyas); $x++) { echo $wdsprfyas[$x] . ","; } ?>],
    }]
  },

  // Configuration options
  options: {
    layout: {
      padding: 10,
    },
    legend: {
      position: '',
    },
    title: {
      display: false,
      text: 'Windspeed'
    },
    scales: {
      yAxes: [{
        scaleLabel: {
          display: true,
          labelString: 'Windspeed in kilometer per hour'
        }
      }],
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: 'Time of the day'
        }
      }]
    }
  }
});

</script>
  </div>
  <div class="rightrightcolumn">
      <h3 style="background-color: #0761aa; padding: 10px; margin-left: 10px; color: white;">Air pressure</h3>

    <canvas id="myChart1" width="100%" height="75px"></canvas>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>

<script>
var ctx = document.getElementById('myChart1').getContext('2d');
var chart = new Chart(ctx, {
  // The type of chart we want to create
  type: 'line', // also try bar or other graph types

  // The data for our dataset
  data: {
    labels: [<?php for($x = 0; $x < count($stprfyas); $x++) { echo "'" . $rfxas[$x] . "',"; } ?>],
    // Information about the dataset
    datasets: [{
      label: "mbar",
      backgroundColor: '',
      borderColor: 'royalblue',
      data: [<?php for($x = 0; $x < count($stprfyas); $x++) { echo $stprfyas[$x] . ","; } ?>],
    }]
  },

  // Configuration options
  options: {
    layout: {
      padding: 10,
    },
    legend: {
      position: '',
    },
    title: {
      display: false,
      text: 'Air pressure'
    },
    scales: {
      yAxes: [{
        scaleLabel: {
          display: true,
          labelString: 'Air pressure in millibar'
        }
      }],
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: 'Time of the day'
        }
      }]
    }
  }
});

</script>
</div>
<h3 style="background-color: #0761aa; padding: 10px; margin-top: 525px; color: white;">Wind direction</h3>

<canvas id="myChart2" width="100%" height="20px"></canvas>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>

<script>
var ctx = document.getElementById('myChart2').getContext('2d');
var chart = new Chart(ctx, {
  // The type of chart we want to create
  type: 'line', // also try bar or other graph types

  // The data for our dataset
  data: {
    labels: [<?php for($x = 0; $x < count($wnddirrfyas); $x++) { echo "'" . $rfxas[$x] . "',"; } ?>],
    // Information about the dataset
    datasets: [{
      label: "degrees",
      backgroundColor: 'orange',
      borderColor: 'royalblue',
      data: [<?php for($x = 0; $x < count($wnddirrfyas); $x++) { echo $wnddirrfyas[$x] . ","; } ?>],
    }]
  },

  // Configuration options
  options: {
    layout: {
      padding: 10,
    },
    legend: {
      position: '',
    },
    title: {
      display: false,
      text: 'winddirection'
    },
    scales: {
      yAxes: [{
        scaleLabel: {
          display: true,
          labelString: 'Wind direction in degrees'
        }
      }],
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: 'Time of the day'
        }
      }]
    }
  }
});
</script>
</div>
</div>
</div>


<script>
function searchFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}

/* OSM & OL example code provided by https://mediarealm.com.au/ */
var map;
var mapLat = <?php echo $_SESSION["lati"]; ?>;
var mapLng = <?php echo $_SESSION["long"]; ?>;
var mapDefaultZoom = 11;
function initialize_map() {
map = new ol.Map({
target: "map",
layers: [
new ol.layer.Tile({
source: new ol.source.OSM({
url: "https://a.tile.openstreetmap.org/{z}/{x}/{y}.png"
})
})
],
view: new ol.View({
center: ol.proj.fromLonLat([mapLng, mapLat]),
zoom: mapDefaultZoom
})
});
}
function add_map_point(lat, lng) {
var vectorLayer = new ol.layer.Vector({
source:new ol.source.Vector({
features: [new ol.Feature({
geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lng), parseFloat(lat)], 'EPSG:4326', 'EPSG:3857')),
})]
}),
style: new ol.style.Style({
image: new ol.style.Icon({
anchor: [0.5, 0.5],
anchorXUnits: "fraction",
anchorYUnits: "fraction",
src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
})
})
});
map.addLayer(vectorLayer);
}

window.onscroll = function() {myFunction()};

var header = document.getElementById("content");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>

<div class="footer">
<?php
echo "&copy; " . date("Y") . " SpaceGems";
?>
</div>
</body>
</html>
