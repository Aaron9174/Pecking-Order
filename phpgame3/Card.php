<?php
class AnimalCard
{
	public $name;
	public $mana;
	public $sacrifice;
	public $attack;
	public $type;
	
	function __construct($name,$mana,$sacrifice,$attack,$type)
	{
		$this->$name = $name;
		$this->$mana = $mana;
		$this->$sacrifice = $sacrifice;
		$this->$attack = $attack;
		$this->$type = $type;
	}
}

class SpellCard
{
	public $name;
	public $mana;
	public $effect;
	
	function __construct($name,$mana,$effect)
	{
		$this->$name = $name;
		$this->$mana = $mana;
		$this->$effect = $effect;
	}
}