<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "email_queue")]
class Email {
	#[Id, Column(name: "id", type: "integer"), GeneratedValue()]
	private int $id;

	#[Column(name: "status", type: "integer")]
	private int $status;
	
	#[Column(name: "content", type: "string")]
	private string $content;

	#[Column(name: "reciever", type: "string", length: 255)]
	private string $reciever;

	public function getId(): int {
		return $this->id;
	}

	public function getContent(): string {
		return $this->content;
	}

	public function getReciever(): string {
		return $this->reciever;
	}

	public function getStatus(): int {
		return $this->status;
	}

	public function setContent($content) {
		$this->content = $content;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function setReciever($reciever) {
		$this->reciever = $reciever;
	}
}