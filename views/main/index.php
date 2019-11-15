@index.php from view/main/index@

<?php foreach ($vars['users'] as $key)
{
	foreach ($key as $keyarr =>$arr)
	{
		echo '<p>'.$keyarr."->".$arr.'</p>';
	}
}
?>