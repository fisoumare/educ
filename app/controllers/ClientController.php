<?php

class ClientController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter(function()
        {
            return UserAccess::just_for_logged();
        });
    }

    public function getIndex()
    {
        return Redirect::to('client/list');
    }
    
    public function getList()
    {
        $vue = View::make('client.list');
        //Si une recherche a ete envoyee
        if(Input::old()){
            $liste_client = Client::actif()->where('nom','like','%'.trim(Input::old('nom')).'%')
                ->orWhere('prenom','like','%'.trim(Input::old('nom')).'%')
                ->paginate(10);

            $vue->with('success','Résulat de la recherche.');
        }
        else{
            $liste_client = client::actif()->paginate(10);
        }

        return $vue->with('liste_client',$liste_client);
    }

    public function postList()
    {
        $redirect = Redirect::to('client/list');
        if( Input::has('nom') )
        {
            return $redirect->withInput();
        }
        else{
            return $redirect->with('info','Vous devez choisir au moins un critère de recherche.');
        }

    }

    public function getAdd($client_id = '')
    {
        if(!Input::old() AND !empty($client_id) AND Client::actif()->where('id',$client_id)->count() > 0 ){
            $c = Client::find($client_id);
            Input::merge(array(
                'sexe'=>$c->sexe,
                'nom'=>$c->nom,
                'prenom'=>$c->prenom,
                'adresse'=>$c->adresse,
                'tel'=>$c->tel,
                'email'=>$c->email
            ));

            Input::flash();
            return Redirect::to('client/add/'.$c->id);
        }

        if(!empty($client_id)){
            return View::make('client.add')->with('titre_page','Modifier client')->with('client',Client::find($client_id));
        }
        else{
            return View::make('client.add')->with('titre_page','Nouveau client');
        }
    }

    public function postAdd($id = '')
    {
        //Regles de validation
            $rules['sexe'] = 'required';
            $rules['nom'] = 'required';
            $rules['prenom'] = 'required';
            $rules['adresse'] = 'required';
            $rules['tel'] = 'required';
            $rules['email'] = 'email';
        $val = Validator::make(Input::all(),$rules);

        if($val->fails())
        {
            return Redirect::to('client/add')
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        }
        else{
            $redirection = Redirect::to(Request::path());
            if(!empty($id) AND client::find($id) != null){
                $c = Client::find($id);
                //=================================================================================
                //Si un autre client avec la meme email ou telephone existe on le renvoi vers le formulaire
                if( $c->email != Input::get('email') ){
                    $test_client = Client::where('email',Input::get('email'))->first();
                    if( !empty($test_client->id) ){
                        return Redirect::to(Request::path())->withInput()
                            ->with('error','Ce email existe déja pour un autre client.');
                    }
                }

                if($c->tel != Input::get('tel')){
                    $test_client = Client::where('tel',Input::get('tel'))->first();
                    if( !empty($test_client->id) ){
                        return Redirect::to(Request::path())->withInput()
                            ->with('error','Ce numero de téléphone existe déja pour un autre client.');
                    }
                }
                //===================================================================================
                $msg = 'Le client a bien été modifié';
                $redirection->withInput();
            }
            else{
                $c = new client();
                $msg = 'Le client a bien été enregistré';
            }

            $c->sexe = Input::get('sexe');
            $c->nom = Input::get('nom');
            $c->prenom = Input::get('prenom');
            $c->adresse = Input::get('adresse');
            $c->tel = Input::get('tel');
            $c->email = Input::get('email');
            $c->save();

            //Si le user a choisi d'uploader une image
            if(Input::hasFile('userfile')){
                $image = Input::file('userfile');
                $path = public_path().'\assets\img\clients';
                $file_name = $c->id.'_'.sha1($c->nom).' '.sha1($c->prenom).' '.$c->tel.'_'.str_random(20).'.'.$image->getClientOriginalExtension();

                //On verifie si la precende image existe on la supprime
                if( !empty($c->photo) AND file_exists(public_path().'/assets/img/clients/'.$c->photo)){
                    unlink(public_path().'/assets/img/clients/'.$c->photo);
                }

                if($image->move($path,$file_name)){
                    $c->photo = $file_name;
                    $c->save();
                }
            }

            return $redirection->with('success',$msg)->with('id',$c->id);
        }
    }

    public function getView($client_id)
    {
        $client = client::find($client_id);
        if(empty($client_id) OR $client == null){
            return Redirect::to('client/list');
        }

        return View::make('client.view')->with('client',$client);
    }

    public function getDelete( $client_id = '' )
    {
        if( !CurrentUser::is_admin() ){
            return Redirect::to('admin/dashboard');
        }

        $client_to_delete = Client::find($client_id);
        $client_to_delete->etat = 0;
        $client_to_delete->save();

        return Redirect::to('client/list')->with('success','Le client a bien été supprimé.');

    }
}