<?php

$mapreader = new SudokuMapReader();
$ret = $mapreader->Load("Grille.txt");
if ($ret == false) { return (false); }

$grid = new SudokuGrid();
$grid->Init($mapreader->GetGrid());

echo "Solving <br />";
$grid->ShowGrid();
$solver = new SudokuSolver();
$solver->Solve($grid);
echo "<br />";
echo "Solved: <br />";
$grid->ShowGrid();

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

class	SudokuMapReader
{
	private	$p_grid;
	
	public function		__construct()
	{
		$this->p_grid = null;
	}
	
	public function		Load($f)
	{
		$file = file_get_contents($f);
		if ($file == false)
		{ echo "Impossible de lire le fichier<br />"; return (false); }
	
		$lines = explode("\n", $file);
		if (count($lines) < 9)
		{ echo "Fichier corrompu. Manque des lignes.<br />"; return (false); }
	
		$this->p_grid = array();
	
		for ($i = 0; $i < 9; ++$i)
		{
			if (strlen($lines[$i]) < 10)
			{ echo "Fichier corrompu. Manque des caracteres a une ligne.<br />"; return (false); }
		
			$regx = "#^([0-9\-]?)+\r$#";
			$ret = preg_match($regx, $lines[$i]);
			if ($ret == false)
			{ echo "Fichier corrompu. Caractere inconnu.<br />"; return (false); }
		
			for ($j = 0; $j < 9; ++$j)
			{ array_push($this->p_grid, $lines[$i][$j]); }
		}
	
		return (true);
	}
	
	public function		GetGrid()
	{
		return ($this->p_grid);
	}
}

class	SudokuSolver
{
	private		$p_grid;
	
	public function		__construct()
	{
		$this->p_grid = null;
	}
	
	public function		Solve(SudokuGrid $grid)
	{
		$this->p_grid = $grid;

		$ret = $this->Crack(0);
		if ($ret == false)
		{ echo "Fail"; }
	}
	
	private function	Crack($shebang_idx)
	{
		if ($shebang_idx > 80)
			return (true);
		
		$sheb = &$this->p_grid->GetShebang($shebang_idx);
		
		if ($sheb->GetLocked() == true)
		{
			$ret = $this->Crack($shebang_idx + 1);
			return ($ret);
		}
		for ($i = 1; $i <= 9; ++$i)
		{
			$sheb->SetValue($i);
			$valid = $this->IsValid($sheb);
			
			if ($valid == true)
			{
				$ret = $this->Crack($shebang_idx + 1);
				if ($ret == true) { return (true); }
			}
		}
		$sheb->SetValue("-");
		return (false);
	}
	
	private function	IsValid(Shebang $sheb)
	{
		$l = $this->p_grid->GetLines();
		$line = $l[$sheb->GetLine()];
		$c = $this->p_grid->GetColumns();
		$column = $c[$sheb->GetColumn()];
		$s = $this->p_grid->GetSquares();
		$square = $s[$sheb->GetSquare()];
		$value = $sheb->GetValue();
		$onl = 0;
		$onc = 0;
		$ons = 0;
		
		for ($i = 0; $i < 9; ++$i)
		{
			if ($line[$i]->GetValue() == $value)
				++$onl;
			if ($column[$i]->GetValue() == $value)
				++$onc;
			if ($square[$i]->GetValue() == $value)
				++$ons;
			if ($onl == 2 || $onc == 2 || $ons == 2)
				return (false);
		}
		//$this->p_grid->ShowShebangs();
		//echo "]<br />";
		return (true);
	}
}

?>