<?php

namespace App\Helpers;

use App\Model\Entity\Email;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;

class EmailService{
	public function __construct(
		private EntityManagerInterface $em
	) {
	}

	public function addToQueue(Email $email) {
		$email->setStatus(0);
		$this->em->persist($email);
		$this->em->flush();
	}

	public function flushQueue($limit = 5): array {
		$return = ["tosend" => 0, "sent" => 0];
		try {
			//create mailer object
			$mailer = new SendmailMailer();

			//get $limit of unsent emails
			$emails = $this->em->getRepository(Email::class)->findBy(["status" => 0], null, $limit);
			$return["tosend"] = sizeof($emails);
			foreach($emails as $email) {
				try {
					//create message instance
					$mail = new Message();
					$mail->setFrom("realne.penezenky@mail.cpr")
						->addTo($email->getReciever())
						->setBody($email->getContent());
					//send message
					$mailer->send($mail);
					
					//set message as sent
					$email->setStatus(1);	
					$this->em->flush();	

					$return["sent"]++;
				} catch(Exception $emailException) {
					
				}
			}
			return $return;
		} catch(Exception $databaseException) {
			return $return;
		}
	}

	public function clearSent() {
		$emails = $this->em->getRepository(Email::class)->findBy(["status" => 1]);
		foreach($emails as $email) {
			$this->em->remove($email);
			$this->em->flush();
		}
	}
}