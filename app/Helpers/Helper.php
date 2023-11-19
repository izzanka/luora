<?php

function number_format_short($n, $precision = 1) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } elseif ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n * 0.001, $precision);
        $suffix = 'K';
    } elseif ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n * 0.000001, $precision);
        $suffix = 'M';
    } elseif ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n * 0.000000001, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n * 0.000000000001, $precision);
        $suffix = 'T';
    }

    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }

    return $n_format . $suffix;
}
