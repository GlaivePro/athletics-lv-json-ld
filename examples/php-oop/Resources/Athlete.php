<?php

namespace Resources;

class Athlete extends \JsonldResource
{
	protected string $type = 'Athlete';
	protected string $path = 'athlete/';

	public function __construct($person)
	{
		$this->id = $person->id;
		
		$this->givenName = $person->first_name;
		$this->familyName = $person->last_name;

        $this->gender = match($person->gender) {
			'm' => 'Male',
			'f' => 'Female',
		};

		if ($person->country)
			$this->nationality = 'countrycode:'.$person->country->alpha3;

        $this->birthDate = $person->date_of_birth;
	}
}
