<?php
include ("dbh.inc.php"); 


/* appel à la BDD, requête et affichage des infos des machines  */
/* version 2 */
$myDB = Dbh::connexion ();
$sql = "SELECT * FROM virtualmachines WHERE vmid = ?";

$stmt = $myDB->prepare($sql);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($comment, $mac, $memory, $name, $status, $uuid, $vcpu, $vmid, $vmtype, $date_insert, $date_update);
$stmt->fetch();
$stmt->close();

echo "<p>Comment : ".$comment;
echo "<br>";
echo "<p>Mac : ".$mac;
echo "<br>";
echo "<p>Memory : ".$memory;
echo "<br>";
echo "<p>Name : ".$name;
echo "<br>";
echo "<p>Status : ".$status;
echo "<br>";
echo "<p>UUID : ".$uuid;
echo "<br>";
echo "<p>VCPU : ".$vcpu;
echo "<br>";
echo "<p>VMID : ".$vmid;
echo "<br>";
echo "<p>VMTYPE : ".$vmtype;
echo "<br>";
echo "<p>Date d'ajout : ".$date_insert;
echo "<br>";
echo "<p>Dernier update : ".$date_update;
echo "<br>";

?>