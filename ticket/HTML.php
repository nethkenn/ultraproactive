<html lang="en">
  <head>
    <link href="CSS.CSS" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="ticket-holder">
    <?php for ($i = 301; $i <= 400; $i++): ?>
        "<div class="ticket">
        <img src="ticket.jpg">
        <div class="side-id"><?php echo str_pad($i, 3, '0', STR_PAD_LEFT); $i ?></div>
        <div class="id"><?php echo str_pad($i, 3, '0', STR_PAD_LEFT); ?></div>
      </div>";
    <?php endfor ?> 
      
    </div>
  </body>
</html>