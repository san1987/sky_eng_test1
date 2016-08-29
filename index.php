<?

require_once "db.php";

if (!isset($_GET["days_in_period"])){
	?>
    <form method=get action=.>    ¬ведите количество дней в периоде:
    <input type='text' name='days_in_period' value='3'><input type=submit>
    </form>
	<?
	die;
}


$days_in_period=intval($_GET["days_in_period"]);

$r=mq("SELECT `added` FROM  `clients`  ORDER BY `added` ASC LIMIT 1");
$row=fetch($r);
$start_date=$row["added"];


$r=mq("SELECT  COUNT(`id`) AS `conversion` , CEIL(DATEDIFF(`added`, '$start_date') / $days_in_period ) AS `period_num` FROM  `clients`
	GROUP BY `period_num`
     ");
$pic_file="report.png";
echo "<img src='$pic_file?t=".time()."'><table>";
$data=array();
$max=0;
while ($row=fetch($r)){	echo "<tr><td>".$row["period_num"]."</td><td>".$row["conversion"]."</td></tr>";
	$data[$row["period_num"]]=$row["conversion"];
	if ($row["conversion"]>$max)
		$max=$row["conversion"];}
echo "</table>";

$w=1200;
$h=800;
$im = imagecreatetruecolor ($w, $h);

$text_color = imagecolorallocate($im, 0, 0, 0);
$line_color = imagecolorallocate($im, 255, 0, 0);
$white = imagecolorallocate($im, 255, 255, 255);
imagefilledrectangle($im, 0,0,$w, $h, $white);

$padding=30;

imagefilledrectangle($im,  $last_x=$padding, $last_y=$h-$padding, $w-$padding, $h-$padding+2, $text_color);
imagefilledrectangle($im,  $padding, $h-$padding, $padding+2, $padding, $text_color);
$o=10;
for ($i=0; $i<=$o; $i++){	imagestring($im, 3, 0, $h-$padding-(($h-2*$padding)/$o*$i),  ceil($max/$o*$i), $text_color);
	if ($i) imagestring($im, 3,  $padding+(($w-2*$padding)/$o*$i), $h-$padding+3,  ceil(count($data)/$o*$i), $text_color);}


foreach($data as $k=>$v){	$x=$padding+$k*($w-2*$padding)/count($data);
	$y=$padding+($max-$v)/$max*($h-2*$padding);
	if (false) imagestring($im, 3, $x, $y,  $v."($k)", $text_color);
	imageline($im , $last_x, $last_y, $x, $y, $line_color);
	$last_x=$x;
	$last_y=$y;}




// Draw a white rectangle


//imagestring($im, 1, 5, 5,  "A Simple Text String", $text_color);

imagepng($im, $pic_file);
imagedestroy($im);

