<?php
/**
 * QuizMeister. Developed by Chris Dennett (dessimat0r@gmail.com)
 * Donate by PayPal to dessimat0r@gmail.com.
 * Bitcoin: 1JrHT9F96GjHYHHNFmBN2oRt79DDk5kzHq
 */

function intcmp($a,$b) {
    return ($a-$b) ? ($a-$b)/abs($a-$b) : 0;
}

function usortarr(&$array, $key, $callback = 'strnatcasecmp') {
    uasort($array, function($a, $b) use($key, $callback) {
        return call_user_func($callback, $a[$key], $b[$key]);
    });
}

// Checks if string starts with defined text
function starts_with( $string, $starts ) {
    strncmp($string, $starts, strlen($starts)) == 0;
}

// return string padded with specified number of non-breaking spaces
function get_spaces($spaces) {
    $str = '';
    for ($i = 0; $i < $spaces; $i++) {
        $str .= '&nbsp;';
    }
    return $str;
}

// filters tags field to only contain text and commas
function qm_clean_tags( $string ) {
    $string = preg_replace( '/\s*,\s*/', ',', rtrim( trim( $string ), ' ,' ) );
    return $string;
}
?>
