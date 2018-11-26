<?php


//KAFKA config between RATING and RISK ASSESSMENT ADAPTER 

//connections
$K_rating_url = "localhost"; 
$K_rating_port = "";
//topics 
$K_rating_profiles = "risk-profile-topic"; // queue of risk profiles
$K_rating_refinements = "refinements"; // queue of refinement requests <Topic,threat level,time>

/*
 *
 * OTHER CONFIGURATIONS
 *
*/
//threasholds for SOC events
$soc_bl_tr = 35;
$soc_pr_tr = 75;

//risk colors
//$colors = array("#9964FF","#4BC0C0","#FFD056","#36A2EB","#FF6384");
$colors = array("#01CC01","#5EFE5C", "#FCDF19", "#FE860C", "#FE0000");

//overall likelihood labels
//$likelihood_texts = array("VERY LOW","LOW","MODERATE","HIGH","VERY HIGH");
$likelihood_texts = array("Very low exposition","Low exposition","Moderate exposition","High exposition","Very high exposition");

//risk labels
//$risk_texts = array("VERY LOW","LOW","MODERATE","HIGH","VERY HIGH");
$risk_texts = array("No danger","Low danger","Moderate danger","High danger","Very high danger");

//vulnerability labels
//$vuln_texts = array("VERY LOW","LOW","MODERATE","HIGH","VERY HIGH");
$vuln_texts = array("Very low vulnerability","Low vulnerability","Moderate vulnerability","High vulnerability","Very high vulnerability");


?>
