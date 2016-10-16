<?php
class CurrentUser
{
    /*
     * $attr est un attribut de l'objet
     * */
    static function get( $attr = '')
    {

        if(!empty($attr)){
            return User::where('id',Session::get('user_id'))->pluck($attr);
        }
        else{
            return User::find(Session::get('user_id'));
        }
    }

    static function is_admin()
    {
        if( CurrentUser::get('type') == 'Administrateur' ){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    static function is_gerant()
    {
        if( CurrentUser::get('type') == 'Administrateur' ){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
}