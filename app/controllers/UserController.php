<?php

class UserController extends BaseController {

    public function getIndex()
    {
        if( CurrentUser::is_admin() == false ){
            return UserAccess::just_for_admin();
        }

        return Redirect::to('user/list');
    }
    
    public function getList()
    {
        if( CurrentUser::is_admin() == false ){
            return UserAccess::just_for_admin();
        }

        if(CurrentUser::get()->type != 'Administrateur'){
            return Redirect::to('admin/dashboard');
        }

        $vue = View::make('user.list');
        //Si une recherche a ete envoyee
        if(Input::old()){
            $liste_user = User::actif()->where('nom','like','%'.trim(Input::old('nom')).'%')
                ->orWhere('prenom','like','%'.trim(Input::old('nom')).'%')
                ->orWhere('identifiant','like','%'.trim(Input::old('nom')).'%')
                ->paginate(10);

            $vue->with('success','Résulat de la recherche.');
        }
        else{
            $liste_user = User::actif()->paginate(10);
        }

        return $vue->with('liste_user',$liste_user);
    }

    public function postList()
    {
        if( CurrentUser::is_admin() == false ){
            return UserAccess::just_for_admin();
        }

        if(CurrentUser::get()->type != 'Administrateur'){
            return Redirect::to('admin/dashboard');
        }

        $redirect = Redirect::to('user/list');
        if( Input::has('nom') )
        {
            return $redirect->withInput();
        }
        else{
            return $redirect->with('info','Vous devez choisir au moins un critère de recherche.');
        }

    }

    public function getAdd( $id = '')
    {
        if(!empty($id)){
            $user = User::find($id);
            if( $id == Session::get('user_id') ){
               $page_title = 'Modifier mon profil';
            }
            else{
                if(CurrentUser::is_admin()){
                    $page_title = 'Modifier utilisateur';
                }
                else{
                    return Redirect::to('admin/dashboard');
                }

            }
        }
        else{
            $user = new User();
            $page_title = 'Nouvel utilisateur';
        }

        return View::make('user.add')
            ->with('page_title',$page_title)
            ->with('user',$user);
    }

    public function postAdd($id = '')
    {
        //Regles de validation
            $rules['identifiant'] = 'required';
            if( empty($id) ){
                $rules['mdp'] = 'required|confirmed';
            }
            else{
                 $rules['mdp'] = 'confirmed';
            }
            $rules['nom'] = 'required';
            $rules['prenom'] = 'required';
        $val = Validator::make(Input::all(),$rules);

        if($val->fails())
        {
            return Redirect::to('user/add')
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        }
        else{
            $redirection = Redirect::to(Request::path());
            if(!empty($id) AND User::find($id) != null){
                $u = User::find($id);
                //=================================================================================
                //Si un autre user avec la meme identifiant existe on le renvoi vers le formulair
                if($u->identifiant != Input::get('identifiant')){
                    $test_user = User::where('identifiant',Input::get('identifiant'))->first();
                    if( !empty($test_user->id) ){
                        return Redirect::to(Request::path())->withInput()
                            ->with('error','Ce identifiant existe déja pour un autre utilisateur.');
                    }
                }
                //===================================================================================
                if( Session::get('user_id') == $id ){
                    $msg = 'Votre profil a bien été modifié';
                }
                else{
                    $msg = 'L\'utilisateur a bien été modifié';
                }

                $redirection->withInput();
            }
            else{
                $u = new User();
                $msg = 'L\'utilisateur a bien été enregistré';
            }

            if(Input::has('type')){
                $u->type = Input::get('type');
            }
            $u->identifiant = Input::get('identifiant');
            if( empty($id) OR (!empty($id) AND Input::has('mdp')) ):
                $u->mdp = sha1(Input::get('mdp'));
            endif;
            $u->nom = Input::get('nom');
            $u->prenom = Input::get('prenom');
            $u->save();

            //Si le user a choisi d'uploader une image
            if(Input::hasFile('userfile')){
                $image = Input::file('userfile');
                $path = public_path().'/assets/img/users';
                $file_name = $u->id.'_'.sha1($u->identifiant).'_'.str_random(20).'.'.$image->getClientOriginalExtension();

                //On verifie si la precende image existe on la supprime
                if( !empty($u->photo) AND file_exists(public_path().'/assets/img/users/'.$u->photo)){
                    unlink(public_path().'/assets/img/users/'.$u->photo);
                }

                if($image->move($path,$file_name)){
                    $u->photo = $file_name;
                    $u->save();
                }
            }

            return $redirection->with('success',$msg)->with('id',$u->id);
        }
    }

    public function getProfil($user_id)
    {
        if( CurrentUser::is_admin() == false ){
            return UserAccess::just_for_admin();
        }

        $user = User::find($user_id);
        if(empty($user_id) OR $user == null){
            return Redirect::to('user/list');
        }

        return View::make('user.profil')
            ->with('page_title','Profil utilisateur')
            ->with('user',$user);
    }

    public function getDelete( $user_id = '' )
    {
        if( !CurrentUser::is_admin() ){
            return Redirect::to('admin/dashboard');
        }

        $user_to_delete = User::find($user_id);
        $user_to_delete->etat = 0;
        $user_to_delete->save();

        return Redirect::to('user/list')->with('success','L\'utilisateur a bien été supprimé.');

    }
}