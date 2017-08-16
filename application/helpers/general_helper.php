<?php
function urlize( $string ) {
    return strtolower( preg_replace( array( '/[^-a-zA-Z0-9\s]/', '/[\s]/' ), array( '', '-' ), $string ) );
}
//helperlar icindeki fonksiyonlara heryerden direk erisebilirsin

