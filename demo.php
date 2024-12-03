<?php

use Mgleis\Sqlitequeue\Job;
use Mgleis\Sqlitequeue\Queue;
use Mgleis\Sqlitequeue\Worker;

require 'vendor/autoload.php';

$queue = new Queue("jobs.sqlite", 'queue');
$queue->push('hi');
$queue->push("a string");
$queue->push(["an" => "array"]);
$queue->push([0, 1, 2, 3, 4]);
$queue->push(['type' => 'SendEmail', 'to' => '...']);

$w = new Worker($queue);
$w
    ->withMaxTotalRuntimeInSeconds(60)
    ->withMaxJobCount(60)
    ->withSleepTimeBetweenJobsInMilliseconds(1)
    ->withSleepTimeOnEmptyQueueInMilliseconds(100)
    ;
$w->process(function(Job $job) {
    echo "starting...\n";
    echo $job->id . "\n";
    var_dump($job);
    echo "done...\n";
});

echo "remaining jobs: " . $q->size() . "\n";
