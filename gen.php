<?

require_once "db.php";

$i=200000;
while ($i--){
	$d=rand(1,28);
	$m=rand(1,12);
	mq("INSERT INTO  `clients` (`id`, `fio`, `phone`, `status`, `added`)
	VALUES (NULL, 'test', '+000000000000', 'new', '2016-$m-$d 08:00:00'); ");}

echo "Completed.";
