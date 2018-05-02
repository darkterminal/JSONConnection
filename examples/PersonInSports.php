<?php

class PersonInSports
{
	public $code;
	public $name;
	public $sports;

	public $data = [];

	public function code( int $code )
	{
		$this->code = $code;
		return $this;
	}

	public function name( string $name )
	{
		$this->name = $name;
		return $this;
	}

	public function sports( string $sports )
	{
		$this->sports = $sports;
		return $this;
	}

	public function get()
	{
		$this->data = [
			'Code' => $this->code,
			'Name' => $this->name,
			'Sports' => $this->sports
		];

		return $this->data;
	}
}