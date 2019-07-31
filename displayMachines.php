<?php
include ("dbh.inc.php"); 

$myDB = Dbh::connexion ();
$sql = "SELECT * FROM machines WHERE id = ?";

$stmt = $myDB->prepare($sql);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $name, $os, $status, $type, $comment, $port);
$stmt->fetch();
$stmt->close();

/* echo "<table>";
echo "<tr>";
echo "<th>ID</th>";
echo "<td>" . $id . "</td>";
echo "<th>Name</th>";
echo "<td>" . $name . "</td>";
echo "<th>OS</th>";
echo "<td>" . $os . "</td>";
echo "<th>Status</th>";
echo "<td>" . $status . "</td>";
echo "<th>Type</th>";
echo "<td>" . $type . "</td>";
echo "<th>Comment</th>";
echo "<td>" . $comment . "</td>";
echo "<th>Port</th>";
echo "<td>" . $port . "</td>";
echo "</tr>";
echo "</table>"; */

echo "<p>Name : ".$name;
echo "<br>";
echo "<p>OS : ".$os;
echo "<br>";
echo "<p>Status : ".$status;
echo "<br>";
echo "<p>Type : ".$type;
echo "<br>";
echo "<p>Comment : ".$comment;
echo "<br>";
echo "<p>Port : ".$port;
echo "<br>";



?>