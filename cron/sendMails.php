#!/usr/bin/env php
<?php
namespace App\Cron;

use App;
use App\Helpers\EmailService;

require __DIR__ . '/../vendor/autoload.php';

$container = App\Bootstrap::bootForCron()->createContainer();

$emailService = $container->getByType(EmailService::class);

//send emails according to set limit (or default one)
//get associative array result
$result = $emailService->flushQueue();
$response = time();

//if number of sent emails equals number of emails that were supposed to be sent
if($result["sent"] == $result["tosend"]) {
	$response .= " - SUCCESS";
//else if atleast one email was sent
} elseif($result["sent"] > 0) {
	$response .= " - PARTIAL FAILURE";
//if no email was sent
} else {
	$response .= " - FAILURE";
}
$response .= " [{$result["sent"]}/{$result["tosend"]}]";
echo $response . "\n";