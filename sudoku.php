<?php

require_once("SudokuMapReader.php");
require_once("Shebang.php");
require_once("SudokuGrid.php");
require_once("SudokuSolver.php");

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

?>