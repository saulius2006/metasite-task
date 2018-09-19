<?php
// src/Entity/Task.php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Registration
{
	/**
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	public $email;

	/**
	 * @Assert\NotBlank()
	 */
	public $name;

	/**
	 * @Assert\NotBlank()
	 */
	public $category;


	public function getDataFile() {
		return getcwd().'/../data/Registrations.json';
	}

	public function getEmail()
	{
		return $this->email;
	}
	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getCategory()
	{
		return $this->category;
	}
	public function setCategory($category)
	{
		$this->category = $category;
	}
	public function getName()
	{
		return $this->name;
	}
	public function setName($name)
	{
		$this->name = $name;
	}
	
	public function setRegistration($registration)
	{
		return $this->registration;
	}
	public function getRegistration($registration)
	{
		$this->registration = $registration;
	}
	public function save() {
		$json = file_get_contents($this->getDataFile());
		if ($json) {
			$registrations = json_decode($json, true);
		} else {
			$registrations = [];
		}
		$data_to_save = [
			'name' => $this->getName(),
			'email' => $this->getEmail(),
			'category' => $this->getCategory(),
		];
		$registrations[$this->email] = $data_to_save;
		return file_put_contents($this->getDataFile(), json_encode($registrations)) ? true : false;
	}
}