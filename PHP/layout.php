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
            $stnnum = $nummer[1];
        }
    }
}
    fclose($handle);
}
?>
<div class="row">
  <div class="leftcolumn">
      <div class="card">
        <input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Search for names.." title="Type in a name">
          <div class="vertical-menu">
<?php
                for($x = 0; $x < $_SESSION['get']; $x++){
?>
                <a href="layout.php?name=<?php echo $_SESSION['city'][$x]; ?>" class="<?php if(strtoupper($_GET["name"]) == strtoupper($_SESSION['city'][$x])){ echo "active";} else{ echo "passive"; } ?>">

<?php
                echo $_SESSION['city'][$x];
?>
                </a>

<?php
}
?>
          </div>

              </ul>
            </div>
          </div>

  <div class="rightcolumn">
    <div class="card">
      <div class="h2"><?php echo ucwords(strtolower($_SESSION["name"])); ?></div>
    </div>
    <div class="card">
      <h3 style="background-color: #0761aa; padding: 10px; color: white;">Map</h3>
    </style>
    <body onload="initialize_map(); add_map_point(<?php echo $_SESSION["lati"]; ?>, <?php echo $_SESSION["long"]; ?>);">
  <div id="map" style="width: 100%; height: 250px;"></div>

</div>
    <div class="rightleftcolumn">
      <h3 style="background-color: #0761aa; padding: 10px; color: white;">Temperature</h3>
      <p><div id="chartContainer" style="height: 250px; width: 100%;"></div></p>
  </div>
  <div class="rightrightcolumn">
      <h3 style="background-color: #0761aa; padding: 10px; color: white;">Temperature</h3>

        <div id="chartContainer2" style="height: 250px; width: 100%;"></div>
  </div>
<div class="card">
  <?php

$files = glob("Data/*xml");

if (is_array($files)) {

     foreach($files as $filename) {
        $xml_file = simplexml_load_file($filename) or die("Error: Cannot create object");
        foreach($xml_file->children() as $ja){
          if($ja->STN == $stnnum){
            echo $ja->STN . "</br>";
        echo $ja->DATE . "</br>";
        echo $ja->TIME . "</br>";
        echo $ja->TEMP . "</br>";
        echo $ja->DEWP . "</br>";
        echo $ja->WDSP . "</br>";
        echo $ja->CLDC . "</br>";
          }
        }
     }
}
?>
</div>
</div>
</div>
</div>
<div class="footer">
  <h2>Footer</h2>
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
  </script>
</script>

</body>
</html>
