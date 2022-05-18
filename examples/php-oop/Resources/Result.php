<?php

namespace Resources;

class Result extends \JsonldResource
{
	protected string $type = 'Result';
	protected string $path = 'result/';

	public function __construct($result)
	{
		$this->id = $result->id;

		$this->place = $result->place;
		$this->competitor = new Competitor($result);
		$this->performance = new TimePerformance($result);
	}
}
