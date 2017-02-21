<!DOCTYPE html>
<html lang="de">
  <head>
    <title>Vorlesungssammler</title>
    <meta http-equiv="Content-Type"  content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"/>
    <link rel="icon" href="images/icon.png" type="image/png">
  </head>
  <body>
    <div class="col-md-6 col-md-offset-3" role="main">
      <nav class="navbar navbar-inverse" style="border-top-left-radius: 0 !important; border-top-right-radius: 0 !important;">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <a class="navbar-brand" href="./">
              Vorlesungssammler
            </a>
          </div>
        </div><!-- /.container-fluid -->
      </nav>

      <?php
        // Define the file where the results should be stored here:
        $FILE_PATH = "./vorlesungen.txt";

	// Delete unwanted characters
        $titel  = strip_tags(str_replace(array("'",'"',";"), array("","",""), $_POST["titel"]));
        $dozent = strip_tags(str_replace(array("'",'"',";"), array("","",""), $_POST["dozent"]));
        $modul  = strip_tags(str_replace(array("'",'"',";"), array("","",""), $_POST["modul"]));
        $url    = strip_tags(str_replace(array("'",'"',";"), array("","",""), $_POST["url"]));
        $reason = strip_tags(str_replace(array("'",'"',";"), array("","",""), $_POST["reason"]));
        $mail   = strip_tags(str_replace(array("'",'"',";"), array("","",""), $_POST["mail"]));

	$is_entry_correct = isset($titel) && isset($dozent) && isset($modul) && isset($url) &&
                            strlen($titel) > 0 && strlen($dozent) > 0 && strlen($modul) > 0 &&
                            strlen($url) > 0;

        if($is_entry_correct) {
          $line = $titel . ";" . $dozent . ";" . $modul . ";" . $url . ";" . $reason . ";" . $mail . "\n";

	  if(strlen($line)) {
            $success = file_put_contents($FILE_PATH, $line, FILE_APPEND | LOCK_EX);
          } else {
            $success = false;
          }

          $message = '<div class="alert ';
          if(!$success) {
            $message .= 'alert-danger" role="alert">';
            $message .= '<strong>Achtung!</strong> ';
            $message .= 'Leider ist beim Einreichen von ' . $titel . ' ein Fehler passiert. Bitte versuche es später nochmal.';
          } else {
            $message .= 'alert-success" role="alert">';
            $message .= '<strong>Vielen Dank!</strong> ';
            $message .= $titel . ' wurde erfolgreich eingereicht!';
          }
          $message .= '</div>';

          echo $message;
        } 
     ?>


     <form action="./" method="post">
       <div class="form-group">
         <label for="titel">Name der Veranstaltung</label>
         <input type="text" class="form-control" name="titel" placeholder='z.B. "Datenanalyse in R"' required>
       </div>

       <div class="form-group">
         <label for="dozent">Verantwortlicher Dozent</label>
         <input type="text" class="form-control" name="dozent" placeholder='z.B. "Verena Seibold"' required>
       </div>

       <div class="form-group">
         <label for="modul">Gewünschtes Modul</label>
         <select name="modul" class="form-control" required>
           <option disabled selected>Bitte auswählen</option>

           <option value="pphilobsc">Pflichtmodul Philosophie (Bachelor)</option>
           <option value="plingubsc">Pflichtmodul Linguistik (Bachelor)</option>
           <option value="wpinfobsc">Wahlpflichtmodul Informatik (Bachelor)</option>
           <option value="wpkognibsc">Wahlpflichtmodul Kognition (Bachelor)</option>

           <option value="kogninfmsc">Kognitive Informatik (Master)</option>
           <option value="kogneuromsc">Kognitive Neurowissenschaft (Master)</option>
           <option value="kogpsychmsc">Kognitionspsychologie (Master)</option>
           <option value="koglingmsc">Linguistik und Philosophie (Master)</option>
         </select>
       </div>

       <div class="form-group">
         <label for="url">Link zur Campusseite</label>
           <input type="text" class="form-control" name="url" aria-describedby="basic-addon3" placeholder='https://campus.verwaltung.uni-tuebingen.de/...' required>
       </div>

       <div class="form-group">
         <label for="reason">Begründung: (optional)</label><br>
         <textarea class="form-control" rows="5" name="reason"></textarea>
       </div>
     
       <div class="form-group">
         <label for="mail"> 
           Mailadresse für Rückfragen (optional)
         </label>
         <div class="input-group">
           <input type="text" class="form-control" placeholder='"vorname.name" oder "zx-Kürzel"' aria-describedby="mail">
           <span class="input-group-addon" name="mail">
             @student.uni-tuebingen.de
           </span>
         </div>
       </div>

       <div class="form-group col-md-6 col-md-offset-3">
         <button type="submit" class="btn btn-default form-control">Anmelden</button>
       </div>
     </form>
      <div class="col-md-6 col-md-offset-3" style="text-align: center;">
	<p>&copy; 
	<?php 
	  if(date("Y") == 2017) {
            echo "2017";
	  } else {
	    echo "2017 - " . date("Y");
	  }
	?>
        Fachschaft Kognitionswissenschaft</p>
      </div>
      </div>
    </div>
  </body>
</html>
