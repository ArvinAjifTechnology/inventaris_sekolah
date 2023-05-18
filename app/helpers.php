<?php

if (!function_exists('convertToRupiah')) {
    function convertToRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
