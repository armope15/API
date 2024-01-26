<?php



function lista(array $arr, bool $comillas = true)
{
    $result = array();
    if ($comillas) {
        $result = implode(', ', array_map(function ($elemento) {
            return "'" . $elemento . "'";
        }, $arr));
    }
    else
    {
        $result = implode(', ',$arr);
    }
    return $result;
}
