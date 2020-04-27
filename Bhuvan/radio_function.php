<?php
function radio()
{
$json=file_get_contents('radio.json');
return $arry=json_decode($json,1);
}
//$arry=radio();
//var_dump($arry);
//echo $arry['title'];
//echo $arry[items][1]['url'];
?>