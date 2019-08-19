<?php
include ("dbh.inc.php"); 


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


/* requête d'insert dans la BDD à partir du fichier XML */
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


?>


