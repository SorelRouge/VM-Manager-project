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


/****************************** index.html ANCIENNE PARTIE DROPDOWN MENU  *****************************/
?>