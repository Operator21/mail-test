#!/usr/bin/env php
<?php
namespace App\Cron;

use App;
use App\Helpers\EmailService;

require __DIR__ . '/../vendor/autoload.php';

$contaniner = App\Bootstrap::bootForCron()->createContainer();

$emailService = $contaniner->getByType(EmailService::class);

$result = $emailService->flushQueue();
$response = time();
if($result["sent"] == $result["tosend"]) {
	$response .= " - SUCCESS";
} elseif($result["sent"] > 0) {
	$response .= " - PARTIAL FAILURE";
} else {
	$response .= " - FAILURE";
}
$response .= " [{$result["sent"]}/{$result["tosend"]}]";
echo $response . "\n";