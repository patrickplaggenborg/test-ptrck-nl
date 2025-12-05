<?php

function overflow32($v)
{
    $v = $v % 4294967296;
    if ($v > 2147483647) return $v - 4294967296;
    elseif ($v < -2147483648) return $v + 4294967296;
    else return $v;
}

function hashCode( $s )
{
    $h = 0;
    $len = strlen($s);
    for($i = 0; $i < $len; $i++)
    {
        $h = overflow32(31 * $h + ord($s[$i]));
    }

    return $h;
}

$hashinput = $_GET['check'];

$hashoutput = hashCode($hashinput);

?>

normal: <?=$hashinput;?><br /><br />
hashcode: <?=$hashoutput;?>
