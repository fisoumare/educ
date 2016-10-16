<?php
/*
 * Cette fonction retourne un tableau contenant la liste des sessions
 * */
function getSession( $min_year = 1970){
    $result = array();
    for( $date = date('Y'); $date >= $min_year; $date-- ){
        $result[] = ($date-1).' - '.$date;
    }
    return $result;
}