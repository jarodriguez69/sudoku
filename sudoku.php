<?php
define('nl',"\n");
$sqRows=3;
$sqCols=3;

$s='000602000;600000002;080753040;907020406;002409300;106080509;060174090;400000005;000805000';

$start=hrtime(true);
solve($sqCols,$sqRows,$s);

$ms=0.000001*(hrtime(true)-$start);
echo("time elapsed: $ms ms");
echo "<br>";

function solve($sqCols, $sqRows, $s)
{
    global $globalPossibles, $squareRows, $squareCols;
    $squareRows=$sqRows; 
    $squareCols=$sqCols;

    $lines = explode(';', $s);
    $board = array();

    foreach($lines as $line)
    {
        $board[]= str_split($line);
    }

    $globalPossibles = array();

    for($i=0; $i<=count($board);$i++)
    {
        $globalPossibles[]=$i;
    }
   
    printBoard($board);
    solveBoard($board,0,0);
}

function printBoard(&$board)
{
    foreach($board as $row)
    {
        echo(implode('',$row));
        echo "<br>";

    }
    echo "<br>";

}

function solveBoard(&$board, $r, $c)
{
    if($r==count($board))
    {
        echo('resuelto');
        echo "<br>";
        printBoard($board);
        return true;
    }

    $nextC = ($c+1<count($board[0]))?$c+1:0;
    $nextR = ($nextC==0)?$r+1:$r;

    if($board[$r][$c]>0)
    {
        return solveBoard($board,$nextR, $nextC);
    }

    $possibles = getPossibles($board,$r, $c);

    foreach($possibles as $possible)
    {
        if($possible>0)
        {
            $board[$r][$c]=$possible;
            if(solveBoard($board, $nextR, $nextC))
            {
                return true;
            }
        }
    }

    $board[$r][$c]=0;
    return false;
}

function getPossibles(&$board, $r0, $c0)
{
    global $globalPossibles, $squareRows, $squareCols;
    $possibles=$globalPossibles;

    for($r=0;$r<count($board);$r++)
    {
        $possibles[$board[$r][$c0]]=0;
    }

    
    for($c=0;$c<count($board[0]);$c++)
    {
        $possibles[$board[$r0][$c]]=0;
    }

    $r=0;
    while($r0-$r>=$squareRows)
    {
        $r+=$squareRows;
    }

    $c=0;
    while($c0-$c>=$squareCols)
    {
        $c+=$squareCols;
    }

    for($dr=0; $dr<$squareRows;$dr++)
    {
        for($dc=0;$dc<$squareCols;$dc++)
        {
            $possibles[$board[$r+$dr][$c+$dc]]=0;
        }

    }
    return $possibles;
}

?>

