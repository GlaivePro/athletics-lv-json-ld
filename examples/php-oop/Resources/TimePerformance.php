<?php

namespace Resources;

class TimePerformance extends \JsonldResource
{
	protected string $type = 'TimePerformance';

	public function __construct($result)
	{
		$this->id = $result->id;

		$this->time = $this->format($result->performance);
	}

	protected function format(string $time): string
	{
		$s = floor($time); // sekundes
		$ms = round(1000 * ($time - $s)); // milisekundes
		// `round` lietots, lai izlīdzinātu peldošo skaitļu aritmētikas problēmas
		// labāk lietot speciālu paplašinājumu (piem bcmath) vai rīkus (DateInterval klasi, Carbon bibliotēku utt.)
	
		$m = floor($s / 60); // minūtes
		$s = $s - 60*$m;
	
		$h = floor($s / 60); // stundas
		$m = $m - 60*$h;
	
		return sprintf('%02d:%02d:%02d.%03d', $h, $m, $s, $ms);
	}

	protected function getId(): string
	{
		return $this->base."result/$this->id.jsonld#performance";
	}
}
