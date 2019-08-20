<!DOCTYPE html>
<?php

include ("requetes.php");
include ("vm/virtualmachines1.php");

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>VMManager</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css"> -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="/front/css/main.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  </head>
  <body>

  <!------------ HEADER --------->
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
      <!------------ END HEADER --------->
<br>
      <!----------- FIRST COLOMN -------->
    <div class="columns" id="columns"> 
      <div class="column is-3 is-offset-1"> 

        <!-- NOUVELLE LISTE -->
      <nav class="panel">
        <p class="panel-heading">
          Liste des machines
        </p>
        <div class="panel-block">
          <p class="control has-icons-left">
            <input class="input is-small" type="text" placeholder="search">
            <span class="icon is-small is-left">
              <i class="fas fa-search" aria-hidden="true"></i>
            </span>
          </p>
        </div>
        <!-- <p class="panel-tabs"> -->
        <div class="panel-block">
        <form class="divFlex" id="bouton" name="bouton" method="post" action="#">
          <label class="label">
            <input  class="button is-info" type="submit" name="valid" id="bouton" value="VM-ID" />
          </label>
      
          <label class="label2">
            <input class="button is-info" type="submit" name="valid2" id="bouton2" value="Projet" />
          </label>

          <label class="label3">
            <input class="button is-info" type="submit" name="valid3" id="bouton3" value="Dernière update" />
          </label>

        </form>
        </div>
        <!-- </p> -->
        <?php
              if (isset($_POST['valid'])) 
              {
                if ($_POST['valid'] == "VM-ID") 
                {
                  insertIntoList();
                } 
              } else if ($_POST['valid2'] == "Projet")
                {
                  insertIntoList2();
                } else if ($_POST['valid3'] == "Dernière update")
                  {
                    insertIntoList3();
                  }   
              ?>
        <?php
        /* insertIntoList(); */
        ?>

        <div class="panel-block">
          <button class="button is-link is-outlined is-fullwidth">
            reset all filters
          </button>
        </div>
      </nav>
       
      </div>
  
        <!----------- SECOND COLOMN -------->
        <div class="column is-half is-offset-1" id="infosMachine">
          <br>
          <h2 class="subtitle has-text-centered">Informations machine selectionnée</h2>
          <br>  
          <!-- Espace affichant les informations relatives à la machine selectionnées -->
          <div class="subtitle-2 has-text-centered" id="displayInfos">
          </div>
        


          <br><br><br><br>
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

            <div id="infosMachines">
            </div>
 
        <!------------ CREATION DE L'OBJET D'APPEL AU DOC XML------------>
      <?php
      $vms = new SimpleXMLElement($xmlstr);                                 
      insertFromXml($vms);
      ?>

    </div>

<!-- Script por l'affichage des infos machines - AJAX -->
<script>
function showMachine(str) {
  if (str == "") {
      document.getElementById("displayInfos").innerHTML = "";
      return;
  } 
  xmlhttp = new XMLHttpRequest();  
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("displayInfos").innerHTML = this.responseText;
    }
  };
  xmlhttp.open("GET","displayMachines.php?q="+str,true);
  xmlhttp.send();
}
</script>

  </body>
</html>
