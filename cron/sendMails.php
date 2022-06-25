#!/usr/bin/env php
<?php
namespace App\Cron;

use App;
use App\Helpers\EmailService;

require __DIR__ . '/../vendor/autoload.php';

$contaniner = App\Bootstrap::bootForCron()->createContainer();

$emailService = $contaniner->getByType(EmailService::class);

$emailService->flushQueue();