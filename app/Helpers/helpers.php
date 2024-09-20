<?php
if (!function_exists('rupiah_format')) {
    function rupiah_format($number)
    {
        return number_format($number, 0, ',', '.');
    }
}
