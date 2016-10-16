<?php
class Ets
{
    /*
     * $attr est un attribut de l'objet
     * */
    static function get( $attr = '')
    {

        if(!empty($attr)){
            return DB::table('config')->where('id',1)->pluck($attr);
        }
        else{
            return DB::table('config')->first();
        }
    }
}