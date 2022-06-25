<?php

namespace App\Presenters\Forms;

use Nette\Application\UI\Form;

class EmailFormFactory {
	public function create(): Form {
		$form = new Form;
		$form->addEmail("email", "Email");

		return $form;
	}
}