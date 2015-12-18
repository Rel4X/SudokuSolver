<?php

require_once("Shebang.php");
require_once("SudokuGrid.php");

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
		return (true);
	}
}

?>