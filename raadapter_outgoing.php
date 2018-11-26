<?php

/* This is a KAFKA producer that write messages to DASHBOARD and RATING topics
 * of the COMMUNICATION BUS.
 * Messages are received by RATING (through a KAFKA channel - profiles topic),
 * transformed into dashboard messages and sent to DASHBOARD and forwarded to
 * 
*/
require('utils.php');
require('utils_strategies.php');
require('utils_assets.php');

echo "Consume new risk profile from RATING and produce the edited profile\nto the KAFKA queue named Dashboard and\nKAFKA queue named RATING"; 

$conf = new RdKafka\Conf();

// Set the group id. This is required when storing offsets on the broker
$conf->set('group.id', 'myConsumerGroup');

$rk = new RdKafka\Consumer($conf);
$rk->addBrokers($K_rating_url);

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

$topic = $rk->newTopic($K_rating_profiles, $topicConf);

// Start consuming partition 0
$topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);

// Start consuming partition 0 from the beggining
//$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);


while (true) {
    $message = $topic->consume(0, 120*10000);
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
		
		//get the $RATING_risk_profile
		//var_dump($message);
		$profile = json_decode($message->payload);
		$lpaname=$profile->companyName;
		logger("%date% %file%\t%level%\t%message%", ["level" => "info", "date" =>  date("Y-m-d h:i:sa", time()), "message" =>"Received message from RATING for $lpaname", "file" =>__FILE__]);
           
		//Check the LPA name and get correct IP for the kafka bus
		$commBus = getCommunicationBus($lpaname);
		//print_r($commBus);
		//print("\n");

		$likelihood_double = $profile->overallLikelihood; //double value [1.0-5.0]
		$likelihood = intval($likelihood_double);
		date_default_timezone_set("Europe/Rome");
		$curr_timestamp = date('Y-m-d H:i:s.z');

		
	
		//print("Dashboard Stream creation #################### --------\n");
		///OVERALL LIKELIHOOD
		// create default message for overall likelihood
		// update level, date and content based on overall likelihood

		$content= "Risk level progressed to ";
		$content=$content . $likelihood_texts[$likelihood-1];
		$d_OV_message  = createDashboardMess(10, "Risk Assessemnt", "RATING", $content);
		//print("Overall Message creation ####################\n");
		//var_dump($d_OV_message);
		//print("################# Overall Message ####################\n");

		// create default graph for overall likelihood
		$d_OV_graph = createOverallGraph($likelihood);
		//print("Overall Graph  Creation ####################\n");
		//var_dump($d_OV_graph);
		//print("################# Overall Graph ####################\n");
		
		//create dashboard message with the created messages and graphs
		$d_kafka_message = (object) [
		    'messages' => array(),
		    'graphs' => array(),
		  ];
		
		//Add OV_message into kafka message
		array_push($d_kafka_message->messages, $d_OV_message);
		array_push($d_kafka_message->graphs, $d_OV_graph);
	
		// ATTACK STRATEGIES
		if (sizeof($profile->attackStrategyRisks)>0){
			//create message for Attack strategies
			$d_AS_message = createDashboardMess(10, "Risk management", "RATING", "Attack strategies's ranking updated");
			//print("Attack strategies Message creation ####################\n");
			//var_dump($d_AS_message);
			//print("################# Attack strategies Message ####################\n");

			//create table graph for Attack strategies
			$d_table_AS = createASTable($profile);
			//print("Attack strategies Graph creation####################\n");
			//var_dump($d_table_AS);
			//print("################# Attack strategies Graph ####################\n");
			array_push($d_kafka_message->messages,$d_AS_message);
			array_push($d_kafka_message->graphs, $d_table_AS);
		}

		//ASSETS
		if(sizeof($profile->assetRisks)>0){
			//create message for Assets
			$d_A_message = createDashboardMess(10, "Risk management", "RATING", "Assets's ranking updated");
			//print("Assets Message creation####################\n");
			//var_dump($d_A_message);
			//print("Assets Message ####################\n");

			//create table graph for Assets
			$d_table_A = createATable($profile);
			//print("Assets Graph creation ####################\n");
			//var_dump($d_table_A);
			//print("################# Assets Graph ####################\n");


			array_push($d_kafka_message->messages,$d_A_message);
			array_push($d_kafka_message->graphs, $d_table_A);
		}


		$string_message=json_encode($d_kafka_message);
		print("################# Dashboard Stream ####################\n");
		print($string_message);
		print("\n################# Dashboard Stream ####################\n");
		print("################# RATING Stream ####################\n");
		print($message->payload);
		print("\n################# RATING Stream ####################\n");

		$comm_bus_IP = "127.0.0.1";
		$db_topic = "test";
		//send message to kafka in dashboard and rating topic
		foreach ($commBus['prod'] as $key => $value){
			$comm_bus_IP = "{$value['host']}:{$value['port']}";
			//$comm_bus_IP = "127.0.0.1";
			$db_topic = $value['topicname'];	
			$port= $value['port'];
			echo "KAFKA-IP: $comm_bus_IP, topic: $db_topic\n";
			if($value['component'] === "dashboard"){
					echo "KAFKA-IP: $comm_bus_IP, topic: $db_topic\n";
					produceKafkaMessage($comm_bus_IP, $db_topic, $string_message);
					
			}
			if($value['component'] == "rating"){
					produceKafkaMessage($comm_bus_IP, $db_topic, $message->payload);
					
			}
		}
		
            break;
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
            echo "No more messages; will wait for more\n";
	    print("URL: $K_rating_url - TOPIC: $K_rating_profiles\n");
            break;
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
	    logger("%date% %file%\t%level%\t%message%", ["level" => "warning", "date" =>  date("Y-m-d h:i:sa", time()), "message" =>"KAFKA Consume Timed out", "file" =>__FILE__]);
            echo "Timed out\n";
            break;
        default:
	    logger("%date% %file%\t%level%\t%message%", ["level" => "warning", "date" =>  date("Y-m-d h:i:sa", time()), "message" =>$message->errstr(), "file" =>__FILE__]);
            throw new \Exception($message->errstr(), $message->err);
            break;
    }
}

?>
