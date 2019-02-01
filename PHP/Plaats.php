<!DOCTYPE html>
<head>
	<style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
</head>
<body>
<?php
include('Header.php');

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
        		echo ucwords(strtolower($nummer[2])) . "<br />\n";
        		echo ucwords(strtolower($nummer[0])) . "<br />\n";
        		echo $nummer[5];
        		$stnnum = $nummer[1];
        }
    }
}
    fclose($handle);
}
?>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>
    var myMap;
    var myLatlng = new google.maps.LatLng(<?php echo $nummer[3]; ?>,<?php echo $nummer[4]; ?>);
    function initialize() {
        var mapOptions = {
            zoom: 10,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP  ,
            scrollwheel: false
        }
        myMap = new google.maps.Map(document.getElementById('map'), mapOptions);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: myMap,
            title: '<?php echo ucwords(strtolower($nummer[0])); ?>',
            icon: 'http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png'
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="map" style="width:50%; height: 200px;">

</div>

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

include("Linegraph.php");

?>

</body>
</html>