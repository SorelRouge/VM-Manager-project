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

<!----------- FIRST COLOMN -------->
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

<!----------- SECOND COLOMN -------->
      <div class="column is-three-quarters is-centered">
        <h2 class="subtitle has-text-centered">Informations machine selectionnée</h2>
        <br>  


<!-- Espace affichant les informations relatives à la machine selectionnées -->

        <div class="subtitle-2 has-text-centered" id="displayInfos">
        </div>


      <br><br>
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




        <!------------ QUELQUES TEST ------------>
<?php
$vms = new SimpleXMLElement($xmlstr);
/* print_r ($vms); */
/* print_r ($vms->CONTENT->children()); */
$virtual2 = $vms->CONTENT->children();
print_r ($virtual2[4]->COMMENT);
/* foreach ($vms->CONTENT->children() as $virtual) 
{ 
  echo "Comment : ".$virtual->COMMENT . "<br>";
  echo "Mac : ".$virtual->MAC . "<br>";
  echo "Memory : ".$virtual->MEMORY . "<br>";  
  echo "Name : ".$virtual->NAME . "<br>"; 
  echo "Status : ".$virtual->STATUS . "<br>";
} 
 */



/* *********************************************************** */
/* requête de mise à jour de la BDD à partir du fichier XML */
function machineFromXml($vms)
{ 
  foreach ($vms->CONTENT->children() as $virtual){
    $mysqli = Dbh::connexion();
      /* utilisation */
    $SQL = "INSERT INTO virtualmachines (comment, mac, memory, name, status, uuid, vcpu, vmid, vmtype) VALUES (?,?,?,?,?,?,?,?,?)";
    /* préparation */
    $stmt=$mysqli->prepare($SQL);
    /* bind variable à la préparation */
    $stmt->bind_param('ssisssiss', 
    $virtual->COMMENT ["comment"], 
    $virtual->MAC ["mac"], 
    $virtual->MEMORY ["status"], 
    $virtual->NAME ["type"], 
    $virtual->STATUS ["comment"], 
    $virtual->UUID ["port"], 
    $virtual->VCPU ["vcpu"], 
    $virtual->VMID ["vmid"], 
    $virtual->VMTYPE ["vmtype"]);
    /* execution */
    $ok = $stmt->execute ();
    /* fermeture de l'ordre */
    $stmt->close();
    if($ok)
    {
        $mysqli->commit();
    }
  }
};
/* machineFromXml($vms); */
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
