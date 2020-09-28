<?php

function status(Int $id, String $table_name = 'orders')
{
    if ($table_name === 'orders' && $id === 1) {
        return false;
    }

    if ($table_name === 'parcels' && $id === 6) {
        return false;
    }

    return true;
}