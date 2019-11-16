@index.php from view/main/index@

<?php foreach ($users as $key)
{
	foreach ($key as $keyarr =>$arr)
	{
		echo '<p>'.$keyarr."->".$arr.'</p>';
	}
}
?>