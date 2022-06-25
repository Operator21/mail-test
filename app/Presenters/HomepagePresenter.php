<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Helpers\EmailService;
use App\Model\Entity\Email;
use App\Model\Entity\User;
use App\Presenters\Forms\EmailFormFactory;
use Doctrine\ORM\EntityManagerInterface;
use Nette;
use Nette\Application\UI\Form;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
	public function __construct(
		private EntityManagerInterface $em,
		private EmailFormFactory $formFactory,
		private EmailService $emailService
	) {
	}

	public function beforeRender() {
		$this->template->users = $this->em->getRepository(User::class)->findAll();
		$this->template->unsentEmails = $this->em->getRepository(Email::class)->findBy(["status" => 0]);;
		$this->template->sentEmails = $this->em->getRepository(Email::class)->findBy(["status" => 1]);;
	}

	public function handleCreateUser() {
		$user = new User();
		$user->setEmail();

		$this->em->persist($user);
		$this->em->flush();
	}

	public function handleSendEmail($email) {
		/*$mail = new Message();
		$mail->setFrom("naprostoRealnePenezenky@totalreality.com")
			->addTo($email)
			->setSubject("Test")
			->setBody("Lorem ipsum dolor sit amet");

		$mailer = new SendmailMailer();
		dump($mailer->send($mail));*/
		$mail = new Email();
		$mail->setReciever($email);
		$mail->setContent("Lorem ipsum dolor sit amet");

		$this->emailService->addToQueue($mail);
	}

	protected function createComponentEmailForm(): Form {
		return $this->formFactory->create();
	}

	public function handleFlush(int $status) {
		if($status)
			$this->emailService->clearSent();
		else
			$this->emailService->flushQueue();
	}
}
