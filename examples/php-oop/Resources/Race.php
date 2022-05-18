<?php

namespace Resources;

class Race extends \JsonldResource
{
	protected string $type = 'UnitRace';
	protected string $path = 'race/';

	public function __construct($race)
	{
		$this->id = $race->id;

		$this->results = array_map(fn ($r) => new Result($r), $race->results);
	}
}
