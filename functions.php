<?php 

/**
 * Get clear price
 * @param int $totaprice
 * @param array $taxes
 *
 * $clearPrice = $totalPrice/(sum($taxes * 100%) + 100%)
 * 
 * @return array|null $allPrices
 */
function getPrices($totalPrice, $taxes = array()) {
  $totalPrice = (int) $totalPrice;
  
  if ($totalPrice <= 0) {
    return null;
  }
  
  $taxesSum = 1; // 100%
  
  foreach ($taxes as $tax) {
    $taxesSum += (float) $tax;
  }
  
  $clearPrice = $totalPrice / $taxesSum;
  $VATPrice = $clearPrice * $taxes['vat_tax']; // НДС
  $resortPrice = $clearPrice * $taxes['resort_tax']; // курортный сбор
  
  return array(
    'clear_price' => $clearPrice,
    'vat_price' => $VATPrice,
    'resort_price' => $resortPrice,
  );
}