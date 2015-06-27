<?php

include 'functions.php';

$totalPrice = (!empty($_POST['total_price'])) ? (int) $_POST['total_price'] : 0;

if (!$totalPrice) {
  return;
}

$taxes = array(
  'vat_tax' => 0.2,
  'resort_tax' => 0.01
);

$allPrices = getPrices($totalPrice, $taxes);

// ajax
if (!empty($_POST['is_ajax'])) {
  echo json_encode($allPrices); exit;
}

