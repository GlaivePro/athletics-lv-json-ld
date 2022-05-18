<?php

class JsonldResponse
{
	protected array $data;
	
	public function __construct(JsonldResource $resource)
	{
		$this->data = $resource->getData();

		$this->data['@context'] = 'https://w3c.github.io/opentrack-cg/contexts/opentrack.jsonld';
	}

	public function respond(): void
	{
		// Paziņojam klientam par datu tipu
		header('Content-Type: applicatison:ld+json');
		
		// Nosūtām atbildi
		echo json_encode($this->data);
	}
}
