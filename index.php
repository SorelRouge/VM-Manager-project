<!DOCTYPE html>
<?php

include ("requetes.php");
/* echo 'hello from Docker';
print_r(PDO::getAvailableDrivers()); */

/* $object = new Dbh;
$object->connexion(); */

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VMManager</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css"> -->
    <link rel="stylesheet" type="text/css" href="/front/css/main.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  </head>
  <body>

  <section class="hero is-info">
    <div class="hero-body">
      <div calss="container">
        <h1 class="title is-1 has-text-centered">
          Virtual Machine Manager
        </h1>
        <h2 class="subtitle is-3 has-text-centered">
          Gestionnaire de <strong>machines virtuelles</strong>
        </h2>
      </div>
    </div>
  </section>

  <section class="column is-three-fifths is-offset-one-fifth">
    <div class="columns"> 
      <div class="column">  
        <div class="field">
          <div class="control">
            <div class="select is-info">
              <!-- <select> -->
                <!-- <option>Machine 1</option>
                <option>Machine 2</option>
                <option>Machine 3</option>
                <option>Machine 4</option>
                <option>Machine 5</option> -->
              <?php
              insertIntoDropdown();
              /* echo ($inserted);  */
              ?>
               


              <!-- </select> -->
            </div>
          </div>
        </div>
        <br><br><br><br><br><br><br>
        <h2 class="subtitle">
          Filtres de recherche
        </h2>

        <div class="control">
          <label class="radio">
            <input type="radio" name="answer">Windows</label>       
          <label class="radio">
            <input type="radio" name="answer">Linux</label>
        </div>
        <br><br>
        <button class="button is-info">Rechercher</button>
      </div>

      <div class="column is-three-quarters is-centered">
        <h2 class="subtitle has-text-centered">Informations machine selectionnée</h2>
      <br><br>   

<!-- Espace affichant les informations relatives à la machine selectionnées -->

<div>

</div>


      <!-- Formulaire de connexion à la machine selectionnée -->
        <div class="connectMachine">
          <form action="POST">
            <div class="field">
              <div class="control">
                <input class="input is-hovered" type="text" placeholder="Login">
                <br><br>
                <input class="input is-hovered" type="text" placeholder="Password">
              </div>
            </div>
          </form>
          <br>
          <button class="button is-info">Se connecter</button>
        </div> 


        <br><br>
<!-- Affichage requêtes php -->
        <div>
          <?php
          $machine = array("name" =>"Machine2",
          "os" => "Linux", 
          "status" => "Off",
          "type" => "VM",
          "comment" => "Ceci est la machine 2",
          "port" => "1790");
          /* print_r ($machine); */

          /* ajouterMachine($machine); */
          
          $listeMachines = listerMachines();
          afficherTableau($listeMachines);

          ?>
        </div>

      </div>

      
    </div>            
  </body>
</html>