<?php
class UserAccess
{
    /*
     * $attr est un attribut de l'objet
     * */
    static function just_for_admin( $attr = '')
    {
        if(CurrentUser::get('type') != 'Administrateur'){
            return Redirect::to('admin/dashboard');
        }
    }

    static function just_for_logged()
    {
        if( !Session::has('user_id') AND Request::segment(1) ){
            if( Request::segment(1) != 'home' AND Request::segment(2) != 'login' ){
                return Redirect::to('home/login');
            }
        }
    }

    //===================================================================================================================
    /*
     * Certainne entites (eleve,session,classe) ont besoin d'autre pour fonctionner
     * Cette fonction verifie si il existe au moins une session dans la BDD
     * Si non elle renvoi le user vers la methode commune "information" situee dans le BaseController
     * Cette methode genere alors un message d'information en fonction de l'entity qui doit etre cree (needed_entity) et celle qui
     * qui a besoin de l'autre (entity) pour etre cree
     * */
    public static function needsPeriode( $entity = '', $redirection_link = '' ){
        if( !empty($redirection_link) ){
            $redirection = Redirect::to($redirection_link);
        } else {
            $redirection = Redirect::to('information');
        }

        return $redirection->with('entity',$entity)
            ->with('needed_entity_name','periode')
            ->with('needed_entity_alias_plural','sessions')
            ->with('needed_entity_alias_singular','une session');
    }

    /*
  * Certainne entites (eleve,session,classe) ont besoin d'autre pour fonctionner
  * Cette fonction verifie si il existe au moins une salle de classe dans la BDD
  * Si non elle renvoi le user vers la methode commune "information" situee dans le BaseController
  * Cette methode genere alors un message d'information en fonction de l'entity qui doit etre cree (needed_entity) et celle qui
  * qui a besoin de l'autre (entity) pour etre cree
  * */
    static function needsClassroom( $entity = '', $redirection_link = '' ){
        if( !empty($redirection_link) ){
            $redirection = Redirect::to($redirection_link);
        } else {
            $redirection = Redirect::to('information');

        }
        return $redirection->with('entity',$entity)
            ->with('needed_entity_name','classroom')
            ->with('needed_entity_alias_plural','salles de classe')
            ->with('needed_entity_alias_singular','une salle de classe');

    }

    /*
  * Certainne entites (eleve,session,classe) ont besoin d'autre pour fonctionner
  * Cette fonction verifie si il existe au moins un eleve dans la BDD
  * Si non elle renvoi le user vers la methode commune "information" situee dans le BaseController
  * Cette methode genere alors un message d'information en fonction de l'entity qui doit etre cree (needed_entity) et celle qui
  * qui a besoin de l'autre (entity) pour etre cree
  * */
    static function needsStudent( $redirection_link = '' ){
        if( Student::count() == 0 ){
            if( !empty($redirection_link) ){
                $redirection = Redirect::to($redirection_link);
            } else {
                $redirection = Redirect::to('information');

            }
            return $redirection->with('entity',$entity)
                ->with('needed_entity_name','classroom')
                ->with('needed_entity_alias_plural','salles de classe')
                ->with('needed_entity_alias_singular','une salle de classe');
        }
    }
}