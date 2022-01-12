<?php
require('../database/connection.php');
$checkdata = "select * from chats where port = '$port'";
$sth = $pdo->prepare($checkdata);
$sth->execute(array($search));
// there is no sure working rowCount, so fetch all and count
$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
if (!$rows) {
    echo "Sorry, there are no matching result for <b> $search </b>";
} else {
    echo count($rows) . " results found !<p>";
}

?>