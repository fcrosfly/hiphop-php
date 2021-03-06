<?php

require_once dirname(__FILE__) .  '/new_db.inc';

$db->createCollation('NAT', 'strnatcmp');

$db->exec('CREATE TABLE t (s varchar(4))');

$stmt = $db->prepare('INSERT INTO t VALUES (?)');
foreach(array('a1', 'a10', 'a2') as $s){
	$stmt->bindParam(1, $s);
	$stmt->execute();
}

$defaultSort = $db->query('SELECT s FROM t ORDER BY s');             //memcmp() sort
$naturalSort = $db->query('SELECT s FROM t ORDER BY s COLLATE NAT'); //strnatcmp() sort

echo "default\n";
while ($row = $defaultSort->fetchArray()){
	echo $row['s'], "\n";
}

echo "natural\n";
while ($row = $naturalSort->fetchArray()){
	echo $row['s'], "\n";
}

$db->close();

?>