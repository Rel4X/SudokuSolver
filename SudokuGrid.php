<?php

require_once("Shebang.php");

class	SudokuGrid
{
	private		$p_shebangs;
	private		$p_lines;
	private		$p_columns;
	private		$p_squares;
	
	public function		__construct()
	{
		$this->p_shebangs = null;
		$this->p_lines = null;
		$this->p_columns = null;
		$this->p_squares = null;
	}
	
	public function		Init($map)
	{
		$this->p_shebangs = array();
		$this->p_lines = array();
		$this->p_columns = array();
		$this->p_squares = array();
		
		$squ_pos = -1;
		$squ_osqu = 0;
		$squ_opos = 0;
		
		for ($i = 0; $i < 81; ++$i)
		{
			$this->p_shebangs[$i] = new Shebang($map[$i]);
		
			$lin = (int)($i / 9);
			$lin_pos = (int)($i % 9);
			$this->p_lines[$lin][$lin_pos] = &$this->p_shebangs[$i];
			
			$col = (int)($i % 9);
			$col_pos =  (int)($i / 9);
			$this->p_columns[$col][$col_pos] = &$this->p_shebangs[$i];
			
			$squ = (int)($col / 3) + (3 * (int)($lin / 3));
			if ($squ == $squ_osqu)
			{ ++$squ_pos; }
			else
			{
				$t = $squ_pos;
				$squ_pos = $squ_opos;
				if (($squ + 1) % 3 == 0)
					$squ_opos = $t + 1;
			}
			if ($squ_pos == 9) { $squ_pos = 0; }
			$squ_osqu = $squ;
			$this->p_squares[$squ][$squ_pos] = &$this->p_shebangs[$i];
			
			$this->p_shebangs[$i]->SetLine($lin);
			$this->p_shebangs[$i]->SetColumn($col);
			$this->p_shebangs[$i]->SetSquare($squ);
			if ($map[$i] == "-")
			{ $this->p_shebangs[$i]->SetLocked(false); }
			else
			{ $this->p_shebangs[$i]->SetLocked(true); }
		}
	}
	
	public function		GetShebang($n)
	{
		return ($this->p_shebangs[$n]);
	}
	
	public function		GetLines()
	{
		return ($this->p_lines);
	}
	
	public function		GetColumns()
	{
		return ($this->p_columns);
	}
	
	public function		GetSquares()
	{
		return ($this->p_squares);
	}
	
	public function		ShowShebangs()
	{
		if ($this->p_shebangs == null) { return (false); }
		
		foreach ($this->p_shebangs as $e)
		{
			echo $e->GetValue()." ";
		}
	}
	
	public function		ShowLines()
	{
		if ($this->p_lines == null) { return (false); }
		
		foreach ($this->p_lines as $k => $e)
		{
			echo "<br />Line ".$k."<br />";
			foreach ($e as $sk => $se)
				echo $se->GetValue()." ";
		}
	}
	
	public function		ShowColumns()
	{
		if ($this->p_columns == null) { return (false); }
		
		foreach ($this->p_columns as $k => $e)
		{
			echo "<br />Column ".$k."<br />";
			foreach ($e as $sk => $se)
				echo $se->GetValue()." ";
		}
	}
	
	public function		ShowSquares()
	{
		if ($this->p_squares == null) { return (false); }
		
		foreach ($this->p_squares as $k => $e)
		{
			echo "<br />Squares ".$k."<br />";
			foreach ($e as $sk => $se)
				echo $se->GetValue()." ";
		}
	}
	
	public function		ShowShebangsData($v)
	{
		echo "Ligne: ".$this->p_shebangs[$v]->GetLine()."<br />";
		echo "Colonne: ".$this->p_shebangs[$v]->GetColumn()."<br />";
		echo "Carre: ".$this->p_shebangs[$v]->GetSquare()."<br />";
		echo "Valeur: ".$this->p_shebangs[$v]->GetValue()."<br />";
		echo "Locked: ".(string)$this->p_shebangs[$v]->GetLocked()."<br />";
	}
	
	public function		ShowGrid()
	{
		foreach ($this->p_lines as $l)
		{
			foreach ($l as $c)
			{
				echo $c->GetValue()." ";
			}
			echo "<br />";
		}
	}
}

?>