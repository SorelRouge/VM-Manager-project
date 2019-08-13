<?php
include ("dbh.inc.php"); 


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


/******************* Afiicher ligne *********************/
function afficherLigne ($ligne, $premiereLigne=FALSE)
{
    echo indenter (TRUE), "<tr>", PHP_EOL;
    $tagCell = ($premiereLigne ? "th": "td");
    foreach ($ligne as $nomColonne => $valeurColonne)
    {
        echo indenter (), "<", $tagCell, ">",
        ($premiereLigne ? $nomColonne : $valeurColonne ),
        "</", $tagCell, ">"; PHP_EOL;
    }
    echo indenter (FALSE), "</tr>", PHP_EOL;
}


/**************** indenter ****************/
function indenter ($x = null)
{
    $tab=4;
    static $increment = 0;
    $inc = 0;
    if(is_null($x))
    {
        $inc = $increment;
    }
    elseif($x)
    {
        $inc = $increment++;
    }
    elseif(!$x)
    {
        $inc = --$increment;
    }
    return str_repeat(" ", $inc * $tab);
};


/*************** afficher un tableau *********************/
function afficherTableau ($donnees, $attributs=array())
{
    $premiereLigne= TRUE;

    echo indenter (TRUE), "<table", ">";
    foreach ($donnees as $numeroLigne => $ligne)
    {
        if ($premiereLigne)
        {
            afficherLigne ($ligne, $premiereLigne);
            $premiereLigne = FALSE;
        }
        afficherLigne ($ligne);
    }
    echo indenter (FALSE), "</table>", PHP_EOL;
}


/*************** Incrémentation du menu dropdown depuis la BDD ***************/
function insertIntoDropdown()
{
    $mysqli = Dbh::connexion();
    $records = $mysqli->query("SELECT * FROM virtualmachines");
    echo "<select name='machines' onchange=showMachine(this.value)>";
    echo "<option value=\"\">Select a machine</option>";
    while ($row = $records->fetch_assoc())
    {
        unset($name);
        $name = $row['name'];
        $id = $row['vmid'];
        echo "<option value=\"$id\">" . $name . "</option>";
    }
    
    echo "</select>";
}


/********* récupération des ids des machines ********/
function getIdsMachines()
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
            }


/************** display machines infos *************/
function getMachines() 
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
}


/* requête d'insert dans la BDD à partir du fichier XML */
function insertFromXml($vms)
{ 
    
  foreach ($vms->CONTENT->children() as $virtual)
  {
    $mysqli = Dbh::connexion();
    /* évite les conflits avec les quotes */
    $comment = $mysqli->real_escape_string($virtual->COMMENT);
    $name = $mysqli->real_escape_string($virtual->NAME);
    $status = $mysqli->real_escape_string($virtual->STATUS);

      /* utilisation */
    $SQL = "INSERT INTO virtualmachines 
    (comment, mac, memory, name, status, uuid, vcpu, vmid, vmtype, date_insert) 
    VALUES (?,?,?,?,?,?,?,?,?, NOW()) 
    ON DUPLICATE KEY UPDATE
    comment='$comment',
    mac='$virtual->MAC',
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
/* rnfverjnf 
 name='$virtual->NAME',
memory = $mysqli->quote($virtual->MEMORY),

comment='$virtual->COMMENT',
mac='$virtual->MAC'
*/


?>


