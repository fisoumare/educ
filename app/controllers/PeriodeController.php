<?php

class PeriodeController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter(function(){
            if( CurrentUser::is_admin() == false ){
                return UserAccess::just_for_admin();
            }
        });
    }

    public function getIndex(){
       return Redirect::to('periode/list');
    }

    public function getAdd( $id ='' )
    {
        if( !empty($id) ){
            $periode = Periode::findOrFail($id);
            $page_title = 'Modifier une session';
        } else {
            $periode = new Periode();
            $page_title = 'Nouvelle session';
        }

        return View::make('periode.add')->with('titre_page','Ajouter une nouvelle Session')
            ->with('periode',$periode)
            ->with('page_title',$page_title);
    }

    public function postAdd($id = '')
    {
        //Regles de validation
        if( !empty($id) ):
            $rules['interval'] = 'required|unique:periodes,interval,'.$id;
        else:
            $rules['interval'] = 'required|unique:periodes';
        endif;
        $rules['debut'] = 'required';
        $rules['fin'] = 'required';
        $rules['debut_payement'] = 'required';
        $rules['fin_payement'] = 'required';
        $rules['montant_inscription'] = 'numeric';
        $rules['montant_reinscription'] = 'numeric';
        $rules['scolarite'] = 'numeric';
        $val = Validator::make(Input::all(),$rules);
        if($val->fails()) {
            return Redirect::to(Request::path())
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        } else {
            if(!empty($id)){
                $periode = Periode::findOrFail($id);
                $msg = 'La Session a bien été modifiée';
            } else {
                $periode = new Periode();
                //Si aucune session n'a encore ete cree alors la session est definie comme celle par defaut
                if(Periode::count() == 0){
                    $periode->actif = 'oui';
                }

                $msg = 'La Session a bien été créee';
            }

            $periode->nom = Input::get('nom');

            if( Input::has('actif') AND Input::get('actif') == 'oui' ){
                    Periode::where('actif','=','oui')->update(array('actif'=>'non'));
                    $periode->actif = Input::get('actif');
            }

            if( Input::has('montant_inscription')){
                $periode->montant_inscription = Input::get('montant_inscription');
            } else {
                $periode->montant_inscription = Ets::get('montant_inscription');
            }

            if( Input::has('montant_reinscription')){
                $periode->montant_reinscription = Input::get('montant_reinscription');
            } else {
                $periode->montant_reinscription = Ets::get('montant_reinscription');
            }

            if( Input::has('scolarite')){
                $periode->scolarite = Input::get('scolarite');
            } else {
                $periode->scolarite = Ets::get('scolarite');
            }


            $periode->interval = Input::get('interval');
            $periode->debut = Input::get('debut');
            $periode->fin = Input::get('fin');
            //On verifie si cette session ne depasse pas une annee (364 jours)
            if( FormatDate::diff_jour(Input::get('debut'),Input::get('fin')) > 364 ){
                return Redirect::to(Request::path())
                    ->with('error','Une année scolaire ne peut pas dépasser 365 jours.')->with('id',$periode->id)
                    ->withInput();
            }

            //La date de debut doit etre inferrieur a la date de fin
            if( strtotime(FormatDate::BDD(Input::get('debut'))) >= strtotime(FormatDate::BDD(Input::get('fin'))) ){
                return Redirect::to(Request::path())
                    ->with('error','La date de début de la session ne peut pas être supérieur à la date de fin de session.')->with('id',$periode->id)
                    ->withInput();
            }
            //====================================================================================
            $periode->debut_payement = Input::get('debut_payement');
            $periode->fin_payement = Input::get('fin_payement');
            //On verfie aussi si les debut et fin de payement son dans l'interval de la session
            $annee_debut = explode('/',Input::get('debut'))[2];
            $annee_fin = explode('/',Input::get('fin'))[2];
            $date_debut = explode('/',Input::get('debut'))[2].'-'.explode('/',Input::get('debut'))[1].'-01';
            $date_fin = explode('/',Input::get('fin'))[2].'-'.explode('/',Input::get('fin'))[1].'-01';
            $debut_payement = $annee_debut.'-'.Input::get('debut_payement').'-01';
            $fin_payement = $annee_fin.'-'.Input::get('fin_payement').'-01';
            if( strtotime($debut_payement) < strtotime($date_debut) OR
                strtotime($debut_payement) > strtotime($date_fin) OR
                strtotime($fin_payement) > strtotime($date_fin) OR
                strtotime($fin_payement) < strtotime($date_debut) ){
                return Redirect::to(Request::path())
                    ->with('error','La période de payement des scolarités doit être dans la session.')->with('id',$periode->id)
                    ->withInput();
            }

            //=================================================================================
            $periode->save();

            if(Input::get('lier') == 'oui'){
                //Une fois la session creee, on la lie a toute les entite ki dependent d'elles
                //Pour les salles de classe
                $liste_id_classe = Classroom::lists('id');
                foreach($liste_id_classe as $id){
                    $periode->classrooms()->attach($id);
                }

            }



            return Redirect::to(Request::path())->with('success',$msg)->with('id',$periode->id);
        }
    }

    public function getList()
    {
        $vue = View::make('periode.list');
        //Si une recherche a ete envoyee
        if(Input::old()){
            $liste_user = User::actif()->where('nom','like','%'.trim(Input::old('nom')).'%')
                ->orWhere('prenom','like','%'.trim(Input::old('nom')).'%')
                ->orWhere('identifiant','like','%'.trim(Input::old('nom')).'%')
                ->paginate(10);

            $vue->with('success','Résulat de la recherche.');
        }

        return $vue->with('liste_periode',Periode::orderBy('id')->paginate(10));
    }

    public function getMakeCurrentSession( $id = '' )
    {
        if( empty($id) ){
            return Redirect::to('periode/list');
        }

        //On met dabord l'etat actif de toutes les sessions a la valeur "non"
        Periode::where('actif','=','oui')->update(array('actif'=>'non'));
        $periode = Periode::findOrFail($id);
        $periode->actif = 'oui';
        $periode->save();
        return Redirect::to('periode/list')->with('success','La session '.$periode->interval.' a bien été définie comme session par défaut.');
    }

    public function getDelete( $id ){
        //On recupere la session
        $session = Periode::find($id);
        $liste_eleve = Student::whereHas('periodes',function($q) use($id) {
            $q->where('periode_id',$id);
        })->get();
        if( $liste_eleve != null ){
            foreach( $liste_eleve as $e){
                $session->students()->detach($e->id);
                $e->delete();
            }
        }

        $liste_classrooms = Classroom::whereHas('periodes',function($q) use($id) {
            $q->where('periode_id',$id);
        })->get();
        if( $liste_classrooms != null ){
            foreach( $liste_classrooms as $c){
                $session->classrooms()->detach($c->id);
                $c->delete();
            }
        }

        //On supprime les relations entre les classes et les eleves par rapport a cette session
        DB::table('classroom_student')->where('periode_id',$id)->delete();
        //On supprime les payements par rapport a cette session
        Payment::where('periode_id',$id)->delete();
        $session->delete();

        return Redirect::to('periode/list')->withSuccess('La session '.$session->interval.' a bien été supprimée');

    }

}