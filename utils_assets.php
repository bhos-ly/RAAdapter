<?php

require('kafka_messages.php'); 

//get the $RATING_risk_profile from RATING calling getProfile
$profile = json_decode($RATING_risk_profile);
$likelihood = $profile->overallLikelihood;
date_default_timezone_set("Europe/Rome");
$curr_timestamp = date('Y-m-d H:i:s.z');



function getNamesRiks($element)
{
	$result=array();
	array_push($result,$element->name);
	$texts = $GLOBALS['risk_texts'];
	$index= intval(($element->risk)*5);
	if ($index!=0)
		array_push($result,$texts[$index-1]);
	else{
		array_push($result,$texts[0]);
	}
	return $result;
}
function getBackgroundAsset($element)
{
	//include('adapter_config.php'); //path to the config.php
	$col = $GLOBALS['colors'];
	$index= intval(($element->risk)*5);
	if ($index!=0)
		return $col[$index - 1];
	else{
		return $col[$index];
	}
	
}




//create table graph for Assets
function createATable($profile){
	$new_table = $GLOBALS['db_assets_table_graph'];
	$d_table_A = json_decode($new_table);
	$d_table_A->location=1;
	//get the assets from the $RATING_risk_profile
	$assets = $profile->assetRisks;
	//var_dump($assets);
	//order the assets over risk
	usort($assets, function ($item1, $item2) {
	    if ($item1->risk == $item2->risk) return 0;
	    return $item1->risk > $item2->risk ? -1 : 1;
	});
	//get name and risk and color for each asset
	$ordered_assets = array_map("getNamesRiks",$assets);
	$background_colors = array_map("getBackgroundAsset", $assets);

	//add them into $d_table_A->content->data->datasets and $d_table_A->content->data->backgroundColor
	$d_table_A->content->data->datasets=$ordered_assets;
	$d_table_A->content->data->backgroundColor = $background_colors;
	return $d_table_A;


}
/*$new_table_A = createATable($profile);
print(json_encode($new_table_A));
*/
?>
