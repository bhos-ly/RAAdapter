<?php

require('kafka_messages.php');
//
function produceKafkaMessage($host, $topic_name, $message)
{
	//check params

	//
	$conf = new RdKafka\Conf();

	// Set the group id. This is required when storing offsets on the broker
	$conf->set('group.id', 'myConsumerGroup');

	$topicConf = new RdKafka\TopicConf();
	$topicConf->set('auto.commit.interval.ms', 100);

	// Set the offset store method to 'file'
	$topicConf->set('offset.store.method', 'file');
	$topicConf->set('offset.store.path', sys_get_temp_dir());

	// Alternatively, set the offset store method to 'broker'
	// $topicConf->set('offset.store.method', 'broker');

	// Set where to start consuming messages when there is no initial offset in
	// offset store or the desired offset is out of range.
	// 'smallest': start from the beginning
	$topicConf->set('auto.offset.reset', 'smallest');


	$rk = new RdKafka\Producer();
	$rk->setLogLevel(LOG_DEBUG);
	$rk->addBrokers($host);

	$topic = $rk->newTopic($topic_name);
	try{
		if (!$rk->getMetadata(false, $topic, 2*1000)) {
		    echo "Failed to get metadata, is broker down?\n";
			logger("%date% %file%\t%level%\t%message%", ["level" => "warn", "date" =>  date("Y-m-d h:i:sa", time()), "message" =>"Failed to get produce metadata. Broker may be down (host: $host, topic_name: $topic_name).", "file" =>__FILE__]);
		}
	}catch (Exception $e){
		echo 'Caught exception: ', $e->getMessage(), "\n";
		$err= $e->getMessage();
		
		logger("%date% %file%\t%level%\t%message%", ["level" => "err", "date" =>  date("Y-m-d h:i:sa", time()), "message" =>"$err (host: $host, topic_name: $topic_name).", "file" =>__FILE__]);
		return false;
	}


	$topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
	$rk->poll(0);
	logger("%date% %file%\t%level%\t%message%", ["level" => "info", "date" =>  date("Y-m-d h:i:sa", time()), "message" =>"Message sent (host: $host, topic_name: $topic_name).", "file" =>__FILE__]);
	return true;
	}


//create message for dashboard

function createDashboardMess ($level,$category,$tool,$content){
	
	if (func_num_args()>0){

		$d_AS_message = json_decode($GLOBALS['db_message']);
		$d_AS_message->level= $level ; 
		$time = $GLOBALS['curr_timestamp'];
		$d_AS_message->date= $time;
		$d_AS_message->category=$category; 
		$d_AS_message->tool= $tool;
		$d_AS_message->content= $content;
		return $d_AS_message;
	}
}
//create an overall likelihood graph
function createOverallGraph($likelihood){
	$db_OV_graph = json_decode($GLOBALS['db_doughnut_graph']);
	//update values
	$risk_labels= $GLOBALS['likelihood_texts'];
	$colors = $GLOBALS['colors'];
	$db_OV_graph->content->data->labels[0] = $risk_labels[$likelihood-1];
	$db_OV_graph->content->data->datasets[0]->data[0]=$likelihood;
	$db_OV_graph->content->data->datasets[0]->backgroundColor[0]=$colors[$likelihood-1];
	$db_OV_graph->content->options->title->text=$risk_labels[$likelihood-1];
	return $db_OV_graph;
}

//return the communicationBus object with the details of the kafka infrastructure
function getCommunicationBus($pa_name){
	$result= array(
		"prod" => array(),
		"cons" => array()
	);
	$conf = $GLOBALS['config'];
	$c= $conf['commbus'];
	//print_r($c);
	foreach ($c['prod'] as $key => $value) {
   		//print_r($value);
		
		if($value['paname'] === $pa_name){
			
			array_push($result['prod'], $value);
			}
		};
	foreach ($c['cons'] as $key => $value) {
   		
		
		if($value['paname'] === $pa_name)
			array_push($result['cons'], $value);
		};
	//print_r($result);
	return $result;
};

//getCommunicationBus("CDA");

//log function
function logger($message, array $data, $logfile = "logfile.log"){  
	  
    foreach($data as $key => $val){   
      $message = str_replace("%{$key}%", $val, $message);    
      }    
      $message .= PHP_EOL;    

    return file_put_contents($logfile, $message, FILE_APPEND); } 
date_default_timezone_set("Europe/Rome");
//logger("%date% %file% %level% %message%", ["level" => "warning", "date" =>  date("Y-m-d h:i:sa", time()), "message" =>"this is a message", "file" =>__FILE__]);
?>
