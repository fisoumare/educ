<!DOCTYPE html>
<html lang="fr">
  <head>
      @include('header')
  </head>
  <body>
        <?php echo iconv('UTF-8', 'ISO-8859-15', $child); ?>
  </body>
</html>