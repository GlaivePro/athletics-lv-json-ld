<?php

namespace Resources;

class Competitor extends \JsonldResource
{
	protected string $type = 'Competitor';

	public function __construct($result)
	{
		$this->id = $result->id;
		$participation = $result->participation;

		$this->bibIdentifier = $participation->number;
		$this->agent = new Athlete($participation->person);
	}

	protected function getId()
	{
		return $this->base."result/$this->id.jsonld#competitor";
	}
}
