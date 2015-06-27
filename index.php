<!DOCTYPE html>
<html>
 <head>
   <title>TEZ Tour тестовое задание</title>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="main.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
 </head>
 <body>
  
  <div id="page">
  
    <div class="header">
      <h1>Вычисление размера НДС и размера курортного сбора</h1>
      <hr>
    </div>
    
    <div class="content">
      
      <?php // init vars ?>
      <?php
        $clearPrice = 0;
        $VATPrice = 0;
        $resortPrice = 0;
      ?>
      
      <?php // if form submitted ?>
      <?php if (!empty($_POST)) : ?>
        <?php include 'price_handler.php'; ?>
      <?php endif; ?>
      
      <?php // handle ajax or simple ?>
      <?php
        if (!empty($_POST) and empty($_POST['is_ajax'])) { // no ajax
          if (!empty($allPrices)) { // price_handler.php
            $clearPrice = round($allPrices['clear_price'], 2);
            $VATPrice = round($allPrices['vat_price'], 2);
            $resortPrice = round($allPrices['resort_price'], 2);
          }
        }
      ?>
      
      <form id="calculate_price_form" action="" method="post" name="calculate_price_form">
        <label for="total_price">Введите сумму с включенными налогами:</label>
        <br>
        <input id="total_price" name="total_price" pattern="[0-9.]+" type="text">
        <input type="submit" value="Рассчитать">
      </form>
      
      <div class="all_prices_container">
        <div class="vat_price_container">
          <p>Размер НДС: <span id="vat_price"><?php echo $VATPrice; ?></span> грн.</p>
        </div>
        <div class="">
          <p>Размер Курортного сбора: <span id="resort_price"><?php echo $resortPrice; ?></span> грн.</p>
        </div>
        <div class="">
          <p>Сумма без НДС и курортного сбора: <span id="clear_price"><?php echo $clearPrice; ?></span> грн.</p>
        </div>
      </div>
    </div>
    
    <script>
      var form = $('#calculate_price_form');
      
      if (form) {
        form.submit(function(e) {
          e.preventDefault();
          
          var totalPriceElt = $('#total_price');
          if (!totalPriceElt) return true;
          
          var totalPrice = totalPriceElt.val();
          
          $.ajax({
            method: "POST",
            url: "price_handler.php",
            data: {
              'total_price': totalPrice,
              'is_ajax': true
            }
          }).done(function(response) {
            
            if (!response) {
              return;
            }
            
            response = JSON.parse(response);
            
            var clearPrice = response.clear_price.toFixed(2) || 0;
            var vatPrice = response.vat_price.toFixed(2) || 0;
            var resortPrice = response.resort_price.toFixed(2) || 0;
            
            var clearPriceElt = $('#clear_price');
            var vatPriceElt = $('#vat_price');
            var resortPriceElt = $('#resort_price');
            
            if (!clearPriceElt || !vatPriceElt || !resortPriceElt) {
              return;
            }
            
            clearPriceElt.text(clearPrice);
            vatPriceElt.text(vatPrice);
            resortPriceElt.text(resortPrice);
          });
        });
      }
    </script>
    
    <div class="footer">
      <hr>
      <p>Copyright © 2015 by <a href="https://github.com/Qymaen" target="_blank">Дмитрий Шелудько</a>.</p>
    </div>
    
  </div>
 </body> 
</html>