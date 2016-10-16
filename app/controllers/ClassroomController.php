<?php

class ClassroomController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter(function(){
            if( CurrentUser::is_admin() == false ){
                return UserAccess::just_for_admin();
            }

            //On eleve ne peut etre cree sans l'existence d'une session
            if( Periode::count() == 0 ){
                return UserAccess::needsPeriode('salles de classe');
            }
        });
    }

    public function getIndex(){
        return Redirect::to('classroom/list');
    }

    public function getAdd( $id ='' )
    {

        //On recupere toutes les sessions
        $liste_periode =  Periode::orderBy('id')->get();

        //On recupere la liste des catgories
        $liste_categorie = array();
        foreach( Category::all() as $c ){
            $liste_categorie[$c->id] = $c->nom;
        }

        if( !empty($id) ){
            $classe = Classroom::findOrFail($id);
            $page_title = 'Modifier une classe';
        } else {
            $classe = new Classroom();
            $page_title = 'Nouvelle classe';
        }

        return View::make('classroom.add')->with('titre_page','Ajouter une nouvelle classe')
            ->with('liste_periode',$liste_periode)
            ->with('liste_categorie',$liste_categorie)
            ->with('page_title',$page_title)
            ->with('classe',$classe);
    }

    public function postAdd($id = '')
    {
        //Regles de validation
        $rules['category_id'] = 'required';
        if( !empty($id) ):
            $rules['nom'] = 'required|unique:classrooms,nom,'.$id;
        else:
            $rules['liste_periode'] = 'required';
            $rules['nom'] = 'required|unique:classrooms,nom';
        endif;
        $rules['scolarite'] = 'required|numeric';
        $val = Validator::make(Input::all(),$rules);
        if($val->fails()) {
            return Redirect::to(Request::path())
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        } else {
            if(!empty($id)){
                $classe = Classroom::findOrFail($id);
                $msg = 'Les attributs de la classe ont bien été modifiés';
            } else {
                $classe = new Classroom();
                $msg = 'La classe a bien été créee';
            }

            $classe->nom = Input::get('nom');
            $classe->category_id = Input::get('category_id');
            $classe->scolarite = Input::get('scolarite');
            $classe->save();

            if( empty($id) ){
                foreach( Input::get('liste_periode') as $periode_id){
                    $classe->periodes()->attach($periode_id);
                }
            }

            return Redirect::to(Request::path())->with('success',$msg)->with('id',$classe->id);
        }
    }

    public function getList( $init = '' )
    {
        //Si il n'y a aucune classe alors on desactive la recherche
        if( Classroom::count() == 0 ){
            Session::forget('recherche_classe');
        }

        if( !empty($init) AND $init == 'init' ){
            Session::forget('recherche_classe');
            Return Redirect::to('classroom/list');
        }

        //On recupere toutes les sessions
        $liste_periode =  array('choix'=>'Toutes les sessions');
        $query_periode =  Periode::orderBy('id')->get();
        foreach($query_periode as $p){
            $liste_periode[$p->id] = $p->interval;
        }

        //On recupere toutes les categories
        $liste_categorie =  array('choix'=>'Toutes les catégories');
        $query_categorie =  Category::orderBy('id')->get();
        foreach($query_categorie as $c){
            $liste_categorie[$c->id] = $c->nom;
        }

        if( Session::has('recherche_classe.periode') AND Session::get('recherche_classe.periode') != 'choix' )
        {
            $current_periode_id = Session::get('recherche_classe.periode');
            //dd(Session::get('recherche_classe'));
            if( Session::has('recherche_classe.category') )
            {
                if( Session::has('recherche_classe.nom') )
                {
                    $liste_classe = Classroom::whereHas('periodes',function($q){
                        $q->where('periode_id','=',Session::get('recherche_classe.periode')); })
                        ->where('category_id','=',Session::get('recherche_classe.category'))
                        ->where('nom','like','%'. Session::get('recherche_classe.nom').'%')
                        ->paginate(10);
                }
                else {
                    $liste_classe = Classroom::whereHas('periodes',function($q){
                        $q->where('periode_id','=',Session::get('recherche_classe.periode'));
                    })->where('category_id','=',Session::get('recherche_classe.category'))->paginate(10);
                }
            }
            else if( Session::has('recherche_classe.nom') )
            {
                $liste_classe = Classroom::whereHas('periodes',function($q){
                    $q->where('periode_id','=',Session::get('recherche_classe.periode'));
                })->where('nom','like','%'. Session::get('recherche_classe.nom').'%')->paginate(10);
            }
            else {
                $liste_classe = Classroom::whereHas('periodes',function($q){
                    $q->where('periode_id','=',Session::get('recherche_classe.periode'));
                })->paginate(10);
            }
        }
        else {
            $current_periode_id = Periode::where('actif','=','oui')->pluck('id');
            if( Session::has('recherche_classe.category') ) {
                if( Session::has('recherche_classe.nom') ){
                    $liste_classe = Classroom::where('category_id','=',Session::get('recherche_classe.category'))
                        ->where('nom','like','%'. Session::get('recherche_classe.nom').'%')->paginate(10);
                } else {
                    $liste_classe = Classroom::where('category_id','=',Session::get('recherche_classe.category'))->paginate(10);
                }
            }
            else if( Session::has('recherche_classe.nom') )
            {
                $liste_classe = Classroom::where('nom','like','%'. Session::get('recherche_classe.nom').'%')->paginate(10);
            }
            else {
                $liste_classe = Classroom::paginate(10);
            }
        }

        return View::make('classroom.list',compact('liste_classe','liste_categorie','liste_periode','current_periode_id'));


    }

    public function postList()
    {
        $rules['periode_id'] = 'required';
        $rules['category_id'] = 'required';
        $val = Validator::make(Input::all(),$rules);
        if( $val->passes() ){
            if( Input::has('periode_id') ){
                Session::put('recherche_classe.periode',Input::get('periode_id'));
            } else {
                Session::forget('recherche_classe.periode');
            }

            if( Input::get('category_id') != 'choix' ){
                Session::put('recherche_classe.category',Input::get('category_id'));
            } else {
                Session::forget('recherche_classe.category');
            }

            if( Input::has('nom') ){
                Session::put('recherche_classe.nom',Input::get('nom'));
            } else {
                Session::forget('recherche_classe.nom');
            }

            return Redirect::to(Request::path())->with('success'.'Résultat de votre recherche');

        } else {
            return Redirect::to(Request::path())
                ->withInput()->with('error',current($val->messages()->all()));
        }
    }

    public function postGetListePeriode( $classe_id = '' ){
        if( Request::ajax() ) {
            $liste_periode = array('choix'=>'Choiiser une session');
            $periodes = Classroom::find($classe_id)->periodes()->orderBy('interval','desc')->get();
            if( $periodes->count() > 0 ){
                foreach( $periodes as $p){
                    $liste_periode[$p->id] = $p->interval;
                }

                echo Form::select('periode_id',$liste_periode,null,array('class'=>'form-control'));
            }
            else{
                exit;
            }
        } else {
            exit;
        }
    }

    public function postGetListePeriodeToAdd( $classe_id = '' ){
        if( Request::ajax() ) {
            $result = '';
            $periodes = Periode::orderBy('interval','desc')->get()->filter(function($periodes) use($classe_id)
            {
                $exist = DB::table('classroom_periode')->where('classroom_id','=',$classe_id)
                    ->where('periode_id','=',$periodes->id)->count();
                if( $exist == 0){
                    return $periodes;
                }
            });

            if( $periodes->count() > 0 ){
                foreach( $periodes as $p){
                    $result .= '<div class="checkbox"><label>'.
                        Form::checkbox('liste_periode[]',$p->id,null).' Session '.
                        $p->interval.'</label></div>';
                }

                echo $result;
            }
            else{
                echo 'Aucune autre session à lier à cette classe.';
            }
        } else {
            exit;
        }
    }

    public function postAddToPeriode( $classroom_id = '' )
    {
        $redirection = Redirect::to(Request::input('back'));
        $classe = Classroom::findOrFail($classroom_id);

        $rule['liste_periode'] = 'required';
        $val = Validator::make(Input::all(),$rule);
        if( $val->passes() ){
            foreach( Input::get('liste_periode') as $periode_id ) {
                $data_periodes_name[] = Periode::where('id','=',$periode_id)->pluck('interval');
                $classe->periodes()->attach($periode_id);
            }

            if( count($data_periodes_name) > 1)
            {
                $msg = 'La classe a bien été ajoutée aux sessions ';
                $last_name_offset = count($data_periodes_name)-1;
                for( $i = 0; $i <= $last_name_offset; $i++ ){
                    if( $i == $last_name_offset -1 ){
                        $msg .= $data_periodes_name[$i].' ';
                    }
                    else if( $i == $last_name_offset){
                        $msg .= 'et '.$data_periodes_name[$i];
                    }
                    else {
                        $msg .= $data_periodes_name[$i].', ';
                    }
                }
            } else {
                $msg = 'La classe a bien été ajoutée à la session '.$data_periodes_name[0];
            }

            return $redirection->with('success',$msg);
        } else {
            return $redirection->with('error','Vous devez choisir une session');
        }

    }

    public function postRemoveToPeriode( $classroom_id = '', $periode_id = '' , $plus_dune_session = 'oui' )
    {
        if( empty($classroom_id) OR empty($periode_id) OR $periode_id == 'choix' ){
           return Redirect::to(Request::input('back'))->with('error','Vous devez choisir une session');
        }

        $classe = Classroom::findOrFail($classroom_id);

        if( $classe->periodes()->count() > 1 ){
            $classe->periodes()->detach($periode_id);

            //On suprime l'historique de payement de tous les eleve lies a cette classe pendant cette periode
            $liste_eleve = Student::whereHas('classrooms',function($q) use($classroom_id, $periode_id){
                $q->where('classroom_id','=',$classroom_id)->where('periode_id','=',$periode_id);
            })->get();

            DB::table('periode_student')->where('classroom_id','=',$classroom_id)->where('periode_id','=',$periode_id)->delete();
            DB::table('classroom_student')->where('classroom_id','=',$classroom_id)->where('periode_id','=',$periode_id)->delete();

            //On suprime l'historique de payement de tous les eleve lies a cette classe pendant cette periode
            foreach( $liste_eleve as $e){
                $e->payments()->delete();
            }

        } else if( $plus_dune_session == 'non') {


        } else {
            $periode =  Periode::findOrFail($periode_id);
            return Redirect::to(Request::input('back'))
                ->with('lien','classroom/delete/'.$classroom_id)
                ->with('classe',$classe->nom)->with('periode',$periode->interval)->with('plus_dune_session',true);
        }

        return Redirect::to(Request::input('back'))->with('success','La classe a bien été supprimée de cette période');

    }

    public function postGetPeriodeScolarite()
    {
        if( Input::ajax() ){
            $scolarite = DB::table('classroom_periode')
                ->where('classroom_id','=',Input::get('classroom_id'))
                ->where('periode_id','=',Input::get('periode_id'))->pluck('scolarite');
            if( !empty($scolarite) ){
                echo $scolarite;
            } else{
                $periode = Periode::find(Input::get('periode_id'));
                if( $periode != null){
                    echo $periode->scolarite;
                } else {
                    echo '';
                }

            }

        }else{
            exit;
        }
    }

    public function postSetPeriodeScolarite( $classroom_id = '')
    {
        $p = Periode::find(Input::get('define_payment_periode_id'));
        if( $p == null){
            return \Illuminate\Support\Facades\Redirect::to(Input::get('back'))
                ->with('error','Vous devez choisir une session.');
        }

        $rule = array(
            'define_payment_scolarite' => 'numeric'
        );
        $val = Validator::make(Input::all(),$rule);
        if( $val->passes() ){
            $c = Classroom::find($classroom_id);
            DB::table('classroom_periode')
                ->where('classroom_id','=',$classroom_id)
                ->where('periode_id','=',Input::get('define_payment_periode_id'))->update(array(
                    'scolarite'=>Input::get('define_payment_scolarite')
                ));
            if( Input::get('define_payment_scolarite') == '' ){
                $msg = 'Les frais de scolarité de la classe '.$c->nom.' pour la session '.$p->interval.' ont été réinitialisés';
            }else{
                $msg = 'Les frais de scolarité de la classe '.$c->nom.' pour la session '.$p->interval.' s\'élèvent maintenant à '.Input::get('define_payment_scolarite').' '.Ets::get('devise');
            }

            return \Illuminate\Support\Facades\Redirect::to(Input::get('back'))
                ->with('success',$msg);
        } else {
            return \Illuminate\Support\Facades\Redirect::to(Input::get('back'))
                ->with('error','Vous devez choisir un nombre..');
        }

    }

    public function getDelete( $classroom_id = '' )
    {
        $classe = Classroom::findOrFail($classroom_id);
        foreach( $classe->periodes as $p ){
            $classe->periodes()->detach($p->id);

            //On supprime l'historique de payement de tous les eleve lies a cette classe pendant cette periode
            $liste_eleve = Student::whereHas('classrooms',function($q) use($classroom_id, $p){
                $q->where('classroom_id','=',$classroom_id)->where('periode_id','=',$p->id);
            })->get();

            DB::table('periode_student')->where('classroom_id','=',$classroom_id)->where('periode_id','=',$p->id)->delete();
            DB::table('classroom_student')->where('classroom_id','=',$classroom_id)->where('periode_id','=',$p->id)->delete();

            //On suprime l'historique de payement de tous les eleve lies a cette classe pendant cette periode
            foreach( $liste_eleve as $e){
                $e->payments()->delete();
                $e->delete();
            }
        }
         $classe->delete();

        return Redirect::to('classroom/list')->with('success','La classe a bien été supprimée.');

    }
}