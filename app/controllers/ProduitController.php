<?php

class ProduitController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter(function(){
            return UserAccess::just_for_logged();
        });
    }

    public function getIndex()
    {
        return Redirect::to('produit/list');
    }
    
    public function getList()
    {
        $vue = View::make('produit.list');
        //Si une recherche a ete envoyee
        if(Input::old()){
            $liste_produit = Produit::actif()->where(function($q){
                if(Input::old('ref')){
                    $q->where('ref','like','%'.trim(Input::old('ref')).'%');
                }

                if(Input::old('nom')){
                    $q->where('nom','like','%'.trim(Input::old('nom')).'%');
                }
            })->orderBy('created_at','desc')->paginate(10);

            $vue->with('success','Résulat de la recherche.');
        }
        else{
            $liste_produit = Produit::actif()->orderBy('created_at','desc')->paginate(10);
        }

        return $vue->with('liste_produit',$liste_produit);
    }

    public function postList()
    {
        $redirect = Redirect::to('produit/list');
        if( Input::has('ref') OR Input::has('nom') )
        {
            return $redirect->withInput();
        }
        else{
            return $redirect->with('info','Vous devez choisir au moins un critère de recherche.');
        }

    }

    public function getAdd($produit_id = '')
    {
        if(CurrentUser::get()->type != 'Administrateur'){
            return Redirect::to('admin/dashboard');
        }

        if(!Input::old() AND !empty($produit_id) AND Produit::actif()->where('id',$produit_id)->count() > 0 ){
            $p = Produit::find($produit_id);
            Input::merge(array(
                'ref'=>$p->ref,
                'nom'=>$p->nom,
                'prix'=>$p->prix,
                'stock'=>$p->stock,
                'seuil_alert_stock'=>$p->seuil_alert_stock
            ));

            if( $p->expiration != null AND $p->expiration != '0000-00-00' ){
                Input::merge(array(
                    'expiration'=>$p->expiration
                ));
            }

            Input::flash();
            return Redirect::to('produit/add/'.$p->id);
        }

        if(!empty($produit_id)){
            return View::make('produit.add')->with('titre_page','Modifier produit')->with('produit',Produit::find($produit_id));
        }
        else{
            return View::make('produit.add')->with('titre_page','Nouveau produit');
        }
    }

    public function postAdd($id = '')
    {
        if(CurrentUser::get()->type != 'Administrateur'){
            return Redirect::to('admin/dashboard');
        }

        $val = \Illuminate\Support\Facades\Validator::make(Input::all(),array(
            'ref'=>'required',
            'nom'=>'required',
            'prix'=>'required|numeric',
            'stock'=>'required|numeric',
            'seuil_alert_stock'=>'required|numeric',
            'expiration'=>'date_format:Y-m-d',
            'photo'=>'image|max:10000'
        ));

        if($val->fails())
        {
            return Redirect::to('produit/add')
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        }
        else{
            $redirection = Redirect::to(Request::path());
            if(!empty($id) AND Produit::find($id) != null){
                $p = Produit::find($id);
                //=================================================================================
                //Si un autre produit avec la meme reference existe on le renvoi vers le formulaire
                if($p->ref != Input::get('ref')){
                    $test_produit = Produit::where('ref',Input::get('ref'))->first();
                    if( !empty($test_produit->id) ){
                        return Redirect::to(Request::path())->withInput()
                            ->with('error','Cette référence existe déja pour un autre produit.');
                    }
                }
                //===================================================================================
                $msg = 'Le produit a bien été modifié';
                $redirection->withInput();
            }
            else{
                $p = new Produit();
                $msg = 'Le produit a bien été enregistré';
            }

            $p->ref = Input::get('ref');
            $p->nom = Input::get('nom');
            $p->prix = Input::get('prix');
            $p->stock = Input::get('stock');
            $p->seuil_alert_stock = Input::get('seuil_alert_stock');
            $p->expiration = Input::get('expiration');
            $p->save();

            //Si le user a choisi d'uploader une image
            if(Input::hasFile('userfile')){
                $image = Input::file('userfile');
                $path = public_path().'\assets\img\produits';
                $file_name = $p->id.'_'.sha1($p->nom).'_'.str_random(20).'.'.$image->getClientOriginalExtension();

                //On verifie si la precende image existe on la supprime
                if( !empty($p->photo) AND file_exists(public_path().'/assets/img/produits/'.$p->photo)){
                    unlink(public_path().'/assets/img/produits/'.$p->photo);
                }

                if($image->move($path,$file_name)){
                    $p->photo = $file_name;
                    $p->save();
                }
            }

            return $redirection->with('success',$msg)->with('id',$p->id);
        }
    }

    public function postAddStock()
    {
        if( !Input::has('quantite') OR !Input::has('produit_id') ){
            return Redirect::to('produit/list');
        }

        if( !Produit::actif()->where('id',Input::get('produit_id'))->count() > 0 ){
            return Redirect::to('produit/list');
        }

        $p = Produit::actif()->where('id',Input::get('produit_id'))->first();
        $p->increment('stock',Input::get('quantite'));

        return Redirect::to('produit/list')->with('success','Une quantité de '.Input::get('quantite').' a bien été ajoutée au stock
        du produit '.$p->nom);
    }

    public function getView($produit_id)
    {
        $produit = Produit::find($produit_id);
        if(empty($produit_id) OR $produit == null){
            return Redirect::to('produit/list');
        }

        return View::make('produit.view')->with('produit',$produit);
    }

    public function getDelete( $produit_id = '' )
    {
        if( !CurrentUser::is_admin() ){
            return Redirect::to('admin/dashboard');
        }

        $produit_to_delete = Produit::find($produit_id);
        $produit_to_delete->etat = 0;
        $produit_to_delete->save();

        return Redirect::to('produit/list')->with('success','Le produit a bien été supprimé.');

    }
}