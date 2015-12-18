<?php

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

?>