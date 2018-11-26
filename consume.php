
<?php
 
// $argv[1] : ip of the kafka bus
// $argv[2] : topic name

//check params
if ($argc < 3 )
{
    exit( "Missing parameters: call consumer.php with ip and topic name as parameters.\ni.e. php consumer.php 192.168.100.1 topic_name\n" );
}

$conf = new RdKafka\Conf();

// Set the group id. This is required when storing offsets on the broker
$conf->set('group.id', 'myConsumerGroup');

$rk = new RdKafka\Consumer($conf);
$rk->addBrokers($argv[1]);

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

$topic = $rk->newTopic($argv[2], $topicConf);

// Start consuming partition 0
//$topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);

// Start consuming partition 0 from the beggining
$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);


while (true) {
    $message = $topic->consume(0, 120*10000);
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
            var_dump($message);
            // analyse the message
	    // message from SOC
	     // get cathegory
	     // get countUSB 
	     // create json to be sent to Rating <lpa_id, attack_strategy, alter_factor>
	     // call RATING and send the data
 
	    // message from OpenIntel
	    
	    // call RATING	
            break;
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
            echo "No more messages; will wait for more\n";
            break;
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
            echo "Timed out\n";
            break;
        default:
            throw new \Exception($message->errstr(), $message->err);
            break;
    }
}

?>

