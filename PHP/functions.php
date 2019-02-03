<?php
error_reporting(E_ERROR | E_PARSE);

function do_login($id, $timeout, $username, $is_admin)
{
  $_SESSION["auth"] = true;
  $_SESSION["usr_id"] = $id;
  $_SESSION["timeout"] = $timeout;
  $_SESSION["username"] = $username;
  $_SESSION["is_admin"] = $is_admin;
}

function fout($melding) {
  global $fout;
  global $foutmeldingen;
  $foutmeldingen[] = $melding; 
  $fout = true;
}

function print_fouten() {
  global $foutmeldingen;
  if (count($foutmeldingen) == 0) return;
  print('<div class="alert alert-danger" role="alert">');
  $eerste = true;
  foreach ($foutmeldingen as $fout) {
    if (!$eerste) print("<br>");
    print(" - " . $fout);
    $eerste = false;
  }
  print("</div>");
}

function print_meldingen() {
  global $meldingen;
  if (count($meldingen) == 0) return;
  print('<div class="alert alert-info" role="alert">');
  $eerste = true;
  foreach ($meldingen as $melding) {
    if (!$eerste) print("<br>");
    print(" - " . $melding);
    $eerste = false;
  }
  print("</div>");
}

function auto_copyright($year = 'auto'){
 if(intval($year) == 'auto'){ $year = date('Y'); }
   if(intval($year) == date('Y')){ echo intval($year); }
   if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
   if(intval($year) > date('Y')){ echo date('Y'); }
}
?>
