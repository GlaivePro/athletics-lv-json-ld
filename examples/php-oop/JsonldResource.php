<?php

class JsonldResource implements JsonSerializable
{
	protected $data = [];

	protected string $type;

	protected string $base = 'https://athletics.lv/';
	protected string $path;
	protected string $id;

	public function __set($key, $value): void
	{
		$this->data[$key] = $value;
	}

	protected function getId()
	{
		return $this->base.$this->path.$this->id.'.jsonld';
	}

	public function getData(): array
	{
		return array_merge([
			'@id' => $this->getId(),
			'@type' => $this->type,
		], $this->data);
	}

	public function jsonSerialize()
	{
		return $this->getData();
	}
}
