<?php
include ("dbh.inc.php"); 

/* FONCTIONS INSERTION MACHINE DANS LISTE */

/* TRI PAR VMID */
function insertIntoList()
{
    $mysqli = Dbh::connexion();
    $records = $mysqli->query("SELECT * FROM virtualmachines ORDER BY vmid");
    echo "<div class='scrollDiv is-info'>";
    while ($row = $records->fetch_assoc())
    {
        $name = $row['name'];
        $id = $row['vmid'];
        echo "<a id=\"$id\" class=panel-block is-active onclick=showMachine(this.id)>" . $id . "</a>";
    }
    echo "</div>";
} 

/* TRI PAR COMMENT */
function insertIntoList2()
{
    $mysqli = Dbh::connexion();
    $records = $mysqli->query("SELECT * FROM virtualmachines ORDER BY comment");
    echo "<div class='scrollDiv is-info'>";
    while ($row = $records->fetch_assoc())
    {
        $name = $row['comment'];
        $id = $row['vmid'];
        echo "<a id=\"$id\" class=panel-block is-active onclick=showMachine(this.id)>" . $name . "</a>";
    }
    echo "</div>";
}

/* TRI PAR DATE D'UPDATE */
function insertIntoList3()
{
    $mysqli = Dbh::connexion();
    $records = $mysqli->query("SELECT * FROM virtualmachines ORDER BY date_update DESC");
    echo "<div class='scrollDiv is-info'>";
    while ($row = $records->fetch_assoc())
    {
        $name = $row['date_update'].' '.$row['vmid'];
        $id = $row['vmid'];
        echo "<a id=\"$id\" class=panel-block is-active onclick=showMachine(this.id)>" . $name . "</a>";
    }
    echo "</div>";
}


/* NOUVELLE FONCTION DE LOOP ET RECUPERATION DE DONNEES DES FICHIERS XML */
function insertFromXml(){
  $dossier = 'vmFiles/';
  $contenu_dossier = scandir($dossier);
  $iterator = new DirectoryIterator($dossier);

  foreach($iterator as $fichier)
  {
    if(!$fichier->isDot())
    {
      $filesNames = $dossier.$fichier->getFilename();
     /*  echo $filesNames; */
      $xmldata = simplexml_load_file($filesNames);

      foreach($xmldata->CONTENT->children() as $virtual) 
      {         
        /* echo $virtual->VMID; */
        $mysqli = Dbh::connexion();

        $comment=$mysqli->real_escape_string($virtual->COMMENT);
        $mac=$mysqli->real_escape_string($virtual->MAC);
        $name=$mysqli->real_escape_string($virtual->NAME);
        $memory=$mysqli->real_escape_string($virtual->MEMORY);
        $status=$mysqli->real_escape_string($virtual->STATUS);
        $uuid=$mysqli->real_escape_string($virtual->UUID);
        $vcpu=$mysqli->real_escape_string($virtual->VCPU);
        $vmid=$mysqli->real_escape_string($virtual->VMID);
        $vmtype=$mysqli->real_escape_string($virtual->VMTYPE);
        /* echo $virt->VMID; */

        /* Requête */
        $SQL = "INSERT INTO virtualmachines 
        (comment, mac, memory, name, status, uuid, vcpu, vmid, vmtype, date_insert) 
        VALUES (?,?,?,?,?,?,?,?,?, NOW()) 

        /* Définition des clés qui sont mises à jour en cas de changement */
        ON DUPLICATE KEY UPDATE
        comment='$comment',
        mac='$mac',
        memory = '$memory',
        name='$name',
        status='$status',
        uuid='$uuid',
        vcpu='$vcpu',
        vmid='$vmid',
        vmtype='$vmtype'";
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
      }
    }
  }
} 


/* FONCTION DE RECHERCHE VIA SEARCHBAR */
function searchBar()
{
    $mysqli = Dbh::connexion();
  if (isset($_POST['submit-search']))
  {
    $search = mysqli_real_escape_string($mysqli, $_POST['search']);
    
    $sql = "SELECT * FROM virtualmachines WHERE vmid 
    LIKE '%$search%' 
    OR comment LIKE '%$search%'";
    $records = $mysqli->query($sql);
    $queryResult = mysqli_num_rows($records);

    if ($queryResult > 0)
    {
      while ($row = mysqli_fetch_assoc($records))
      {
        $name = $row['comment'].' - '.$row['vmid'];
        $id = $row['vmid'];
        echo "<a id=\"$id\" class=panel-block is-active onclick=showMachine(this.id)>" . $name . "</a>";   
      }
    } else
      {
        echo "no results";
      }
  }
}

?>


