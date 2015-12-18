<?php

class	Shebang
{
	private		$p_value;
	private		$p_locked;
	private		$p_line;
	private		$p_column;
	private		$p_square;
	
	public function		__construct($v)
	{
		$this->p_line = 0;
		$this->p_column = 0;
		$this->p_square = 0;
		$this->p_value = $v;
		$this->p_locked = false;
	}
	
	public function		SetValue($v)
	{
		$this->p_value = $v;
	}
	
	public function		GetValue()
	{
		return ($this->p_value);
	}
	
	public function		SetLocked($v)
	{
		$this->p_locked = $v;
	}
	
	public function		GetLocked()
	{
		return ($this->p_locked);
	}
	
	public function		SetLine($v)
	{
		$this->p_line = $v;
	}
	
	public function		GetLine()
	{
		return ($this->p_line);
	}
	
	public function		SetColumn($v)
	{
		$this->p_column = $v;
	}
	
	public function		GetColumn()
	{
		return ($this->p_column);
	}
	
	public function		SetSquare($v)
	{
		$this->p_square = $v;
	}
	
	public function		GetSquare()
	{
		return ($this->p_square);
	}
}

?>