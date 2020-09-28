<?php

function debug($obj, $toArray = false)
{
    if ($toArray) {
        $obj = $obj->toArray();
    }

    echo '<pre>';
    var_dump($obj);
    echo '</pre>';
}