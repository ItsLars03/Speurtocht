<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="speurtocht.css">
    <title>Friese Poort | Wachtwoord Herstellen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  </head>

  <?php 


if(isset($_POST['submit'])){
            ?>
            <script type="text/javascript"></script>
            <script>
                $("document").ready(function() {
                $('.succes').removeClass("close");
                $('.succes').removeClass("hide");
                $('.succes').addClass("show");
                $('.succes').addClass("showAlert");
            setTimeout(function(){
                $('.succes').removeClass("show");
                $('.succes').addClass("hide");
            },5000);
            setTimeout(function(){
                $('.succes').addClass("close");
            },6000);
            });
            </script>
            <?php
        }
        else{
            ?>
            <script type="text/javascript"></script>
            <script>
                $("document").ready(function() {
                $('.alert').removeClass("close");
                $('.alert').removeClass("hide");
                $('.alert').addClass("show");
                $('.alert').addClass("showAlert");
            setTimeout(function(){
                $('.alert').removeClass("show");
                $('.alert').addClass("hide");
            },5000);
            setTimeout(function(){
                $('.alert').addClass("close");
            },6000);
            });
            </script>
            <?php
        }

        
?>

    <div class="container">
      <div class="row"><br><br><br>
        <div class="col-md-4"></div>
        <div class="col-md-4" style="background-color: #D2D1D1; border-radius:15px;">
          <br><br>
          <form role="form" method="POST">
              <label>Please enter your new password</label><br><br>
              <div class="form-group">
                <input type="password" class="form-control" id="pwd" name="password1" placeholder="Password">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" id="pwd" name="password2" placeholder="Re-type Password">
              </div>
                <button type="submit" class="btn btn-primary pull-right" name="submit" style="display: block; width: 100%;">Opslaan</button>
                <br><br>
                <label>This link will work only once for a limited time period.</label>
                <br>
          </form>
        </div>
    </div>
    <div class="succes hide">
         <span class="fa-solid fa-circle-check"></span>
         <span class="msg">Gelukt: Je wachtwoord is succesvol aangepast!</span> 
      </div>
      <div class="alert hide">
         <span class="fas fa-exclamation-circle"></span>
         <span class="msg">Error: Wachtwoorden komen niet overeen!</span>
      </div>
  </body>
</html>
