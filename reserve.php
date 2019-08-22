<!-- FICHIER REGROUPANT DES FONCTIONS UTILISEES EN COURS DE DEVELOPPEMENT MAIS DESORMAIS OBSOLETE -->

<?php
/***************** Ajout de champs dans la tabble *******************/
function ajouterMachine ($uneMachine)
{ 
    $mysqli = Dbh::connexion();
    /* utilisation */
    $SQL = "INSERT INTO machines (name, os, status, type, comment, port) VALUES (?,?,?,?,?,?)";
    /* préparation */
    $stmt=$mysqli->prepare($SQL);

    /* bind variable à la préparation */
    $stmt->bind_param('sssssi', $uneMachine ["name"], $uneMachine ["os"], $uneMachine ["status"], $uneMachine ["type"], $uneMachine ["comment"], $uneMachine ["port"]);
    /* execution */
    $ok = $stmt->execute ();
    /* fermeture de l'ordre */
    $stmt->close();
    if($ok)
    {
        $mysqli->commit();
    }
}; 


/******************* Lecture d'une table ***********************/
function listerMachines ()
{
	$myDB = Dbh::connexion ();

	$SQL = "SELECT * FROM machines";
	$result = $myDB->query($SQL);
	$rows = array();

	while($row = $result->fetch_assoc())
	{
		$rows[] = $row;
	}
    return $rows;
}

/* FONCTION LISTE BULMA */
/* function insertIntoDropdown()
{
    $mysqli = Dbh::connexion();
    $records = $mysqli->query("SELECT * FROM virtualmachines ORDER BY comment");
    echo "<ul name='machines' onchange=showMachine(this.value)>";
    echo "<li value=\"\">Select a machine</li>";
    while ($row = $records->fetch_assoc())
    {
        unset($name);
        $name = $row['comment'];
        $id = $row['vmid'];
        echo "<li value=\"$id\">" . $name . "</li>";
    }
    
    echo "</ul>";
} */

/********* récupération des ids des machines ********/
/* function getIdsMachines()
            {
              $machinesIds = [];
              $listeMachines = listerMachines();
              foreach ($listeMachines as $ligne)
              {
                foreach ($ligne as $key => $value)
                {
                    if ($key == 'id'){
                      
                      echo $value;
                    } 
                }
              } 
            } */


/************** display machines infos *************/
/* function getMachines() 
{
    $myDB = Dbh::connexion ();
    $SQL = "SELECT * FROM machines";
    $result = $myDB->query($SQL);
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<p>";
          echo "Nom : ".$row['name'];
          echo "<br>";
          echo "OS : ".$row['os'];
          echo "<p>";
        }
    }
} */



/*******************************  **********************************/

/*************** Incrémentation du menu dropdown depuis la BDD ***************/
/* AFFICHE LES COMMENT */
function insertIntoDropdown()
{
    $mysqli = Dbh::connexion();
    $records = $mysqli->query("SELECT * FROM virtualmachines ORDER BY comment");
    echo "<select name='machines' onchange=showMachine(this.value)>";
    echo "<option value=\"\">Select a machine</option>";
    while ($row = $records->fetch_assoc())
    {
        unset($name);
        $name = $row['comment'];
        $id = $row['vmid'];
        echo "<option value=\"$id\">" . $name . "</option>";
    }
    
    echo "</select>";
}


/* AFFICHE LES VMID */
function insertIntoDropdown2()
{
    $mysqli = Dbh::connexion();
    $records = $mysqli->query("SELECT * FROM virtualmachines ORDER BY vmid");
    echo "<select name='machines' onchange=showMachine(this.value)>";
    echo "<option value=\"\">Select a machine</option>";
    while ($row = $records->fetch_assoc())
    {
        unset($name);
        /* $name = $row['comment']; */
        $id = $row['vmid'];
        echo "<option value=\"$id\">" . $id . "</option>";
    }
    
    echo "</select>";
}


/* ancienne requête d'insert dans la BDD à partir du fichier XML (avec un fichier custom, sans boucler sur plusieurs fichiers) */
function insertFromXml($vms)
{ 
    
  foreach ($vms->CONTENT->children() as $virtual)
  {
    $mysqli = Dbh::connexion();

    /* évite les conflits avec les quotes */
    $comment=$mysqli->real_escape_string($virtual->COMMENT);
    $mac=$mysqli->real_escape_string($virtual->MAC);
    $name=$mysqli->real_escape_string($virtual->NAME);
    $status=$mysqli->real_escape_string($virtual->STATUS);

      /* Requête */
    $SQL = "INSERT INTO virtualmachines 
    (comment, mac, memory, name, status, uuid, vcpu, vmid, vmtype, date_insert) 
    VALUES (?,?,?,?,?,?,?,?,?, NOW()) 

    /* Définition des clés qui sont mises à jour en cas de changement */
    ON DUPLICATE KEY UPDATE
    comment='$comment',
    mac='$mac',
    memory = $mysqli->quote($virtual->MEMORY),
    name='$name',
    status='$status',
    uuid='$virtual->UUID',
    vcpu=$mysqli->quote($virtual->VCPU),
    vmid='$virtual->VMID',
    vmtype='$virtual->VMTYPE'";
    /* préparation */
    $stmt=$mysqli->prepare($SQL);
    /* bind variable à la préparation */
    $stmt->bind_param('ssisssiss', 
    $virtual->COMMENT, 
    $virtual->MAC, 
    $virtual->MEMORY, 
    $virtual->NAME, 
    $virtual->STATUS, 
    $virtual->UUID, 
    $virtual->VCPU, 
    $virtual->VMID, 
    $virtual->VMTYPE);
    /* execution */
    $ok = $stmt->execute ();
    /* fermeture de l'ordre */
    $stmt->close();
    if($ok)
    {
        $mysqli->commit();
    }
  };
};
/* L'appel de l'ancienne fonction d'insert, depuis le fichier custom qui était devenu un fichier .php */
  /*$vms = new SimpleXMLElement($xmlstr);                                 
    insertFromXml($vms);*/

    
/* PREMIER ESSAI DE LOOP SUR LES FICHIERS XML */
function loopXml(){
  $dossier = 'vmFiles/';
  $contenu_dossier = scandir($dossier);
  $iterator = new DirectoryIterator($dossier);

  foreach($iterator as $fichier)
  {
    if(!$fichier->isDot())
    {
      $filesNames = $dossier.$fichier->getFilename();
      /* echo $filesNames; */
      $xmldata = simplexml_load_file($filesNames);

      foreach($xmldata->CONTENT->children() as $virtual) 
      {         
       echo $virtual->VMID;
      }
    }
  }
}   
?>
