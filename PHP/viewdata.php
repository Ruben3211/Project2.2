<!DOCTYPE html>
<html>
<head>
<?php
include('include.php');

?>
</head>
<body>
<div class="h2" style="margin-top: 20px;"><?php echo ucwords(strtolower($_SESSION["currname"])) . " " . count($_SESSION["date"]); ?> results</div>
<div style="float: right; width: 1.1%;"><br></div>
<div style="float: left; width: 98.9%;">
<table>
    <tr>
      <th width="20%">Date</th>
      <th width="20%">Time</th>
      <th width="20%">Windspeed in km/h</th>
      <th width="20%">Air pressure in mbar</th>
      <th width="20%">Wind direction</th>     
    </tr>
</table>
</div>
<div  style="height:390px; overflow:auto; width: 100%;">
<table>
    <?php for($x = 0; $x < count($_SESSION["xas"]); $x++){
      ?>
    <tr>

      <td width="20%"><?php echo date("d-m-Y", strtotime($_SESSION["date"][$x])); ?></td>
      <td width="20%"><?php echo $_SESSION["xas"][$x]; ?></td>
      <td width="20%"><?php echo $_SESSION["wdsp"][$x]; ?></td>
      <td width="20%"><?php echo $_SESSION["stp"][$x]; ?></td>
      <td width="20%"><?php
      switch($_SESSION["wnddir"][$x]){
        case $_SESSION["wnddir"][$x] >= 0.00 && $_SESSION["wnddir"][$x] <= 11.25:
          echo "North";
          break;
        case $_SESSION["wnddir"][$x] >= 11.25 && $_SESSION["wnddir"][$x] <= 33.75:
          echo "North-northeast";
          break;
        case $_SESSION["wnddir"][$x] >= 33.75 && $_SESSION["wnddir"][$x] <= 56.25:
          echo "North-east";
          break;
        case $_SESSION["wnddir"][$x] >= 56.25 && $_SESSION["wnddir"][$x] <= 78.75:
          echo "East-northeast";
          break;
        case $_SESSION["wnddir"][$x] >= 78.75 && $_SESSION["wnddir"][$x] <= 101.25:
          echo "East";
          break;
        case $_SESSION["wnddir"][$x] >= 101.25 && $_SESSION["wnddir"][$x] <= 123.75:
          echo "East-southeast";
          break;
        case $_SESSION["wnddir"][$x] >= 123.75 && $_SESSION["wnddir"][$x] <= 146.25:
          echo "South-east";
          break;
        case $_SESSION["wnddir"][$x] >= 146.25 && $_SESSION["wnddir"][$x] <= 168.75:
          echo "South-southeast";
          break;
        case $_SESSION["wnddir"][$x] >= 168.75 && $_SESSION["wnddir"][$x] <= 191.25:
          echo "South";
          break;
        case $_SESSION["wnddir"][$x] >= 191.25 && $_SESSION["wnddir"][$x] <= 213.75:
          echo "South-southwest";
          break;
        case $_SESSION["wnddir"][$x] >= 213.75 && $_SESSION["wnddir"][$x] <= 236.25:
          echo "South-west";
          break;
        case $_SESSION["wnddir"][$x] >= 236.25 && $_SESSION["wnddir"][$x] <= 258.75:
          echo "West-southwest";
          break;
        case $_SESSION["wnddir"][$x] >= 258.75 && $_SESSION["wnddir"][$x] <= 281.25:
          echo "West";
          break;
        case $_SESSION["wnddir"][$x] >= 281.25 && $_SESSION["wnddir"][$x] <= 303.75:
          echo "West-northwest";
          break;
        case $_SESSION["wnddir"][$x] >= 303.75 && $_SESSION["wnddir"][$x] <= 326.25:
          echo "North-west";
          break;
        case $_SESSION["wnddir"][$x] >= 326.25 && $_SESSION["wnddir"][$x] <= 348.75:
          echo "North-northwest";
          break;
        case $_SESSION["wnddir"][$x] >= 348.75 && $_SESSION["wnddir"][$x] <= 360.00:
          echo "North";
          break;
        default:
          echo "werkt niet";
      } 
          ?>
        </td>
    </tr>
  <?php 
} 
?>

</table>
</div>
<?php

?>
<div class="footer">
<?php
echo "&copy; " . date("Y") . " SpaceGems";
?>
</body>
</html>