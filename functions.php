<?php
// Getting a safe input from the user
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//make life easier with defining __ROOT__
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

echo '__ROOT__';
 ?>
