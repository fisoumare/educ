<?php

class VenteController extends BaseController {


    public function __construct()
    {
        $this->beforeFilter(function(){
            return UserAccess::just_for_logged();
        });

    }

    public function getIndex()
    {
        return Redirect::to('vente/add');
    }

    public function getView()
    {
        //Si une recherche est active depuis postView()
        if( Session::has('histo_search') ){
            //On va faire une reque en fonction des paranetres de recherche

            // 1. Le mois ne pouvant pas exister sans l'année, si le user ne choisi pas le mois alors
            if( !Session::has('histo_search.mois') ){
                //1.a Le user a choisi que l'annee
                if( Session::get('histo_search.annee') != 'aucun'){
                    $date_debut = Session::get('histo_search.annee').'-01-01';
                    $date_fin = Session::get('histo_search.annee').'-12-31';
                    $historique = Vente::confirmed()->whereBetween('created_at',array($date_debut,$date_fin))
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
                    Session::forget('histo_search.isday');

                    Session::put('histo_search.debut',$date_debut);
                    Session::put('histo_search.fin',$date_fin);

                    $revenu =  Vente::select(DB::raw('sum(prix * quantite) as revenu'))
                        ->confirmed()->whereBetween('created_at',array($date_debut,$date_fin))->first();
                }
                else //1.a Le user n'a pas choisi l'annee, alors il veut obteni toute l'historique. Donc pas de date
                    //a selectionner
                {
                    Session::forget('histo_search.debut');
                    Session::forget('histo_search.fin');
                    Session::forget('isday');

                    $historique = Vente::select('*')
                        ->addSelect(DB::raw('prix * quantite AS prix_total'))
                        ->confirmed()
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
                    $revenu = Vente::select(DB::raw('sum(prix * quantite) as revenu'))->first();
                }

            }

            // 2. Il ne choisi que l'annee et le mois
            if( Session::has('histo_search.mois') AND !Session::has('histo_search.jour') ){
                Session::forget('isday');

                $date_debut = Session::get('histo_search.annee').'-'.Session::get('histo_search.mois').'-01';
                $date_fin = Session::get('histo_search.annee').'-'.FormatDate::mois_prochain(Session::get('histo_search.mois')).'-01';
                $historique = Vente::confirmed()->whereBetween('created_at',array($date_debut,$date_fin))
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                Session::forget('histo_search.isday');

                Session::put('histo_search.debut',$date_debut);
                Session::put('histo_search.fin',$date_fin);

                $revenu =  Vente::select(DB::raw('sum(prix * quantite) as revenu'))
                    ->confirmed()->whereBetween('created_at',array($date_debut,$date_fin))->first();
            }

            // 3. Il choisi que l'annee, le mois et le jour
            if( Session::has('histo_search.mois') AND Session::has('histo_search.jour') ){
                //Si il choisi une heure minimale
                if( Session::has('histo_search.hmin') ) {
                    $date_debut = Session::get('histo_search.annee').'-'.Session::get('histo_search.mois').'-'.Session::get('histo_search.jour').' '.Session::get('histo_search.hmin').':00';
                    Session::forget('histo_search.isday');
                }
                else{
                    $date_debut = Session::get('histo_search.annee').'-'.Session::get('histo_search.mois').'-'.Session::get('histo_search.jour').' 00:00:00';
                }

                if( Session::has('histo_search.hmax') AND Session::get('histo_search.hmax') != '00:00') {

                    $date_fin = Session::get('histo_search.annee').'-'.Session::get('histo_search.mois').'-'.Session::get('histo_search.jour').' '.Session::get('histo_search.hmax').':00';
                    Session::forget('histo_search.isday');
                }
                else{
                    $date_fin = Session::get('histo_search.annee').'-'.Session::get('histo_search.mois').'-'.Session::get('histo_search.jour').' 23:59:59';
                }

                $historique = Vente::confirmed()->whereBetween('created_at',array($date_debut,$date_fin))
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                //Si aucune heure n'est selectionee, alors il peut valider le jour
                if( !Session::has('histo_search.hmin') AND !Session::has('histo_search.hmax')){
                    Session::put('isday',Session::get('histo_search.annee').'-'.Session::get('histo_search.mois').'-'.Session::get('histo_search.jour'));
                }

                Session::put('histo_search.debut',$date_debut);
                Session::put('histo_search.fin',$date_fin);

                $revenu =  Vente::select(DB::raw('sum(prix * quantite) as revenu'))
                    ->confirmed()->whereBetween('created_at',array($date_debut,$date_fin))->first();
            }
        }
        else{
            $historique = Vente::select('*')
                ->addSelect(DB::raw('prix * quantite AS prix_total'))
                ->confirmed()
                ->whereBetween('created_at',array(date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')))
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            $revenu =  Vente::select(DB::raw('sum(prix * quantite) as revenu'))
                ->confirmed()->whereBetween('created_at',array(date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')))->first();

            Session::put('isday',date('Y=m-d'));
        }

        //var_dump(Session::get('histo_search.isday'));

        return View::make('vente.view')->with('historique',$historique)->with('revenu',$revenu->revenu);
    }

    public function postView()
    {
        $red = Redirect::to('vente/view');
        $val = Validator::make(
            Input::all(),
            array(
                'annee' => 'required',
                'mois' => 'required',
                'jour' => 'required|required_with:hmin,hmax',
                'hmin' => '',
                'hmax' => ''
            )
        );

        if($val->fails()){
            return Redirect::to('vente/view')
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        }
        else{
            if(Input::get('valider') == 'today'){
                Session::forget('histo_search');
                return $red->with('success','Historique complète de toute les ventes effectuées aujourd\'hui.');
            }
            else if(Input::get('valider') == 'tout'){
                Session::forget('histo_search');
                Session::put('histo_search.annee','aucun');
                return $red->with('success','Historique complète de toute les ventes.');
            }

            //Annee
            Session::put('histo_search.annee',Input::get('annee'));

            //Mois
            if( Input::get('mois') != 'aucun' ){
                if( Input::get('annee') != 'aucun' ){
                    Session::put('histo_search.mois',Input::get('mois'));
                }
                else{
                    return Redirect::to('vente/view')
                        ->with('error','Vous devez choisir une année d\'activité.');
                }
            }
            else{
                Session::forget('histo_search.mois');
            }

            //Jour
            if( Input::get('jour') != 'aucun' ){
                if( Input::get('mois') != 'aucun' ){
                    Session::put('histo_search.jour',Input::get('jour'));
                }
                else{
                    return Redirect::to('vente/view')
                        ->with('error','Vous devez choisir le mois.');
                }
            }
            else{
                Session::forget('histo_search.jour');
            }

            if( Input::has('hmin') ){
                if( Input::get('jour') != 'aucun' ){
                    Session::put('histo_search.hmin',Input::get('hmin'));
                }
                else{
                    return Redirect::to('vente/view')
                        ->with('error','Vous devez choisir un jour.');
                }
            }
            else{
                Session::forget('histo_search.hmin');
            }

            if( Input::has('hmax') ){
                if( Input::get('jour') != 'aucun' ){
                    Session::put('histo_search.hmax',Input::get('hmax'));
                }
                else{
                    return Redirect::to('vente/view')
                        ->with('error','Vous devez choisir un jour.');
                }
            }
            else{
                Session::forget('histo_search.hmax');
            }

            //var_dump(Session::get('histo_search.debut'));

            return $red;
        }
    }

    public function postClotureJour()
    {
        if( !Input::has('date') ){
            return Redirect::to('vente/view');
        }

        $cloture = new Cloture();
        $cloture->date_cloture = Input::get('date');
        $cloture->save();

        return Redirect::to('vente/view')->with('success','Le '.FormatDate::lettres(Input::get('date')).' a bien été clôturé.');
    }
    
    public function getList()
    {

        $vue = View::make('user.list');
        //Si une recherche a ete envoyee
        if(Input::old()){
            $liste_user = User::where('nom','like','%'.trim(Input::old('nom')).'%')
                ->orWhere('prenom','like','%'.trim(Input::old('nom')).'%')
                ->paginate(10);

            $vue->with('success','Résulat de la recherche.');
        }
        else{
            $liste_user = User::paginate(10);
        }

        return $vue->with('liste_user',$liste_user);
    }

    public function postList()
    {
        return UserAccess::just_for_admin();

        $redirect = Redirect::to('user/list');
        if( Input::has('nom') )
        {
            return $redirect->withInput();
        }
        else{
            return $redirect->with('info','Vous devez choisir au moins un critère de recherche.');
        }

    }


    public function getAdd($produit_id = '')
    {
        $vue = View::make('vente.add');
        if( Session::has('current_produit_id') ){
            $p = Produit::find(Session::get('current_produit_id'));
            $vue->with('produit',$p);
        }

        $query_client = Client::all();
        $liste_client['client_courant'] = 'Client courant';
        foreach($query_client as $c){
            $liste_client[$c->id] = $c->prenom.' '.$c->nom;
        }
        return $vue->with('titre_page','Vendre un produit')
            ->with('liste_client',$liste_client)
            ->with('panier',Vente::panier()->get());
    }

    public function getSearch()
    {
        return Redirect::to('vente/add');
    }
    //Cette methode recherche un produit a vendre en fonction du code barre
    public function postSearch()
    {
        $redirection = Redirect::to('vente/add');

        if( Input::has('ref') ){
            $p = Produit::actif()->where('ref',Input::get('ref'))->first();
            if( !empty($p->id) ){
                Session::put('current_produit_id',$p->id);
                return Redirect::to('vente/add/'.Session::get('current_produit_id'))->withInput();
            }
            else{
                return $redirection->withInput()
                    ->with('error','Aucun produit avec ce code barre n\'existe dans le stock');
            }
        }
        else{
            return $redirection->with('info','Veuillez renseigner un nom de produit ou un code barre');
        }

    }

    public function postAdd()
    {
        //Regles de validation
        $val = Validator::make(Input::all(),
            array(
                'action_vendre' => 'required',
                'quantite' => 'required|integer',
                'prix' => 'required|numeric',
                'remise' => 'numeric',
                'client' => 'required'
            )
        );

        if($val->fails()) {
            return Redirect::to('vente/add')
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        }
        else{
            $p = Produit::find(Session::get('current_produit_id'));
            //Si le user decide de vendre directement le produit
            if( Input::get('action_vendre') == 'confirmer' OR Input::get('action_vendre') == 'ajouter_panier' ){
                //Si la quantie choisie depasse le stock
                if( Input::get('quantite') > $p->stock ){
                    return Redirect::to('vente/add')
                        ->withInput()
                        ->with('info','La vente ne peut être faite car la quantité que vous vendez est supérieure à celle en stock');
                }

                if(Input::get('action_vendre') == 'confirmer'){
                    $p->decrement('stock',Input::get('quantite'));
                }

                $vente = new Vente();
                $vente->user_id = Session::get('user_id');
                $vente->client_id = Input::get('client');
                $vente->quantite = Input::get('quantite');
                if(Input::has('remise') AND Input::has('remise') > 0){
                    $vente->prix = Input::get('prix') - (Input::get('prix')*Input::get('remise'))/100;
                    $vente->remise = Input::get('remise');
                }
                else{
                    $vente->prix = Input::get('prix');
                    $vente->remise = 0;
                }
                $vente->save();
                $p->ventes()->save($vente);

                if(Input::get('action_vendre') == 'ajouter_panier'){
                    $vente->etat = 2;
                    $vente->save();
                    return Redirect::to('vente/add')->with('success', 'Le produit a bien été ajouté au panier.');
                }
                else{
                    return Redirect::to('vente/add')->with('success', 'Le produit a été vendu avec succès.');
                }
            }
            else{ //Si il decide de reserver la commande

            }
            //$current_produit = Produit::find(Input::post('produit_id'));

            //$redirection = Redirect::to(Request::path());
        }
    }

    public function getUpdate($vente_id = '')
    {
        $vue = View::make('vente.update');
        if( !empty($vente_id) AND !Vente::where('id',$vente_id)->count() > 0 ){
            return \Illuminate\Support\Facades\Redirect::to('vente/view');
        }

        $vente = Vente::find($vente_id);

        $query_client = Client::all();
        $liste_client['client_courant'] = 'Client courant';
        foreach($query_client as $c){
            $liste_client[$c->id] = $c->prenom.' '.$c->nom;
        }
        return $vue->with('titre_page','Modifier une vente')
            ->with('liste_client',$liste_client)
            ->with('produit',$vente->produit)
            ->with('vente',$vente);
    }

    public function postUpdate($vente_id = '')
    {
        if( !empty($vente_id) AND !Vente::where('id',$vente_id)->count() > 0 ){
            return \Illuminate\Support\Facades\Redirect::to('vente/view');
        }

        //Regles de validation
        $val = Validator::make(Input::all(),
            array(
                'modifer_vente' => 'required',
                'quantite' => 'required|integer',
                'prix' => 'required|numeric',
                'remise' => 'numeric',
                'client' => 'required'
            )
        );

        if($val->fails()) {
            return Redirect::to('vente/update/'.$vente->id)
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        }
        else{
            $vente = Vente::find($vente_id);
            $p = $vente->produit;
            //Si la quantie choisie depasse le stock ajoute de la quantite courante
            if( Input::get('quantite') > ($p->stock + $vente->quantite) ){
                return Redirect::to('vente/update/'.$vente->id)
                    ->withInput()
                    ->with('info','La vente ne peut être faite car la quantité que vous vendez est supérieure à celle en stock');
            }

            //On rembourse l'ancien stock dabord
            $p->increment('stock',$vente->quantite);
            //Ensuite on rajoute la nouvelle quantite
            $p->decrement('stock',Input::get('quantite'));

            $vente->user_id = Session::get('user_id');
            $vente->client_id = Input::get('client');
            $vente->quantite = Input::get('quantite');
            if(Input::has('remise') AND Input::has('remise') > 0){
                $vente->prix = Input::get('prix') - (Input::get('prix')*Input::get('remise'))/100;
                $vente->remise = Input::get('remise');
            }
            else{
                $vente->prix = Input::get('prix');
                $vente->remise = 0;
            }

            //On sauvegarde la vente
            $vente->save();
            return Redirect::to('vente/update/'.$vente->id)->with('success', 'La vente a bien été modifiée.');
        }
    }

    public function getDelete($vente_id = '')
    {
        if( !empty($vente_id) AND !Vente::where('id',$vente_id)->count() > 0 ){
            return \Illuminate\Support\Facades\Redirect::to('vente/view');
        }

        $vente = Vente::find($vente_id);
        $vente->produit->increment('stock',$vente->quantite);
        $vente->delete();

        return Redirect::to('vente/view')->with('success','La vente a bien été supprimée.');
    }

    public function postVendrePanier()
    {
        $red = Redirect::to('vente/add');
        if( !Input::has('client_panier') ){
            return $red->with('error','Vous devez choisir un client');
        }

        $client = Client::find(Input::get('client_panier'));
        if( Input::get('client_panier') != 0 AND empty($client->id) ){
            return $red->with('error','Vous devez choisir un client');
        }

        foreach( Vente::panier()->get() as $e ){
            $e->produit()->decrement('stock',$e->quantite);
        }

        Vente::where('etat',2)->update(
            array('etat'=>1,
                'client_id'=>Input::get('client_panier')
            )
        );
        return $red->with('success','Le panier a bien été vendu');
    }

    public function postSupprimerPanier()
    {
        Vente::panier()->delete();
        return Redirect::to('vente/add')->with('success','Le panier a bien été effacé');
    }

    public function getTest()
    {
        echo date('Y-m-d 00:00:00');
    }

}