<?php

namespace App\Model\Entity;

use App\Helpers\StringGenerator;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "user")]
class User {
	#[Id, Column(name: "email", type: "string", length: 255)]
	private string $email;

	public function getEmail(): string {
		return $this->email;
	}

	public function setEmail(?string $email = NULL) {
		if($email)
			$this->email = $email;
		else
			$this->email = StringGenerator::generateString() . "@mailo.com";
	}
}