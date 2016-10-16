<?php

class StudentController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter(function(){
            if( !Session::has('user_id') ){
                return Redirect::to('home/login');
            }

            //On eleve ne peut etre cree sans l'existence d'une session
            if( Periode::count() == 0 ){
               return UserAccess::needsPeriode('Elève');
            }

            //On eleve ne peut etre cree sans l'existence d'une salle de classe
            if( Classroom::count() == 0 ){
               return UserAccess::needsClassroom('Elève');
            }
        });
    }

    public function getIndex(){
        return Redirect::to('student/list');
    }

    public function getProfil( $id ){
        $eleve = Student::findOrFail($id);
        return View::make('student/profil')
            ->withPageTitle('Profil')
            ->withEleve($eleve);
    }

    public function getAdd( $id ='' )
    {

        //On recupere la liste des session
        //1- Si l'élève est déja inscrit on ne prendre que les sessions auxquelles il est lié
        if( empty($id) ){
            $liste_periode = array('choix'=>'Choisir une session');
            foreach( Periode::orderBy('interval','desc')->get() as $p ){
                $liste_periode[$p->id] = $p->interval;
            }
        } else {
            $liste_periode = array('choix'=>'Aucune');
            $sessions = Periode::whereHas('students',function($q) use($id){
                $q->where('student_id','=',$id);
            })->orderBy('interval','desc')->get();
            foreach( $sessions  as $p ){
                $liste_periode[$p->id] = $p->interval;
            }
        }

        //2- Si non on prend toutes les essions

        //On recupere la liste des catgories
        $liste_categorie = array('choix'=>'Choisir une catégorie');
        foreach( Category::all() as $c ){
            $liste_categorie[$c->id] = $c->nom;
        }

        //On recupere la liste des catgories
        $liste_classe = array();
        foreach( Classroom::all() as $c ){
            $liste_classe[$c->id] = $c->nom;
        }

        //On recupere la liste des pays du monde
        $liste_pays = array();
        foreach( Country::all() as $c ){
            $liste_pays[$c->id] = $c->nom;
        }

        //On recupere la liste des villes de guinee
        $liste_ville = array();
        foreach( City::all() as $v ){
            $liste_ville[$v->id] = $v->nom;
        }

        if( !empty($id) ){
            $eleve = Student::findOrFail($id);
            $page_title = 'Modifier un élève';
        } else {
            $eleve = new Student();
            $page_title = 'Inscrire un élève';
        }

        return View::make('student.add')->with('titre_page','Inscrire un Elève')
            ->with('liste_periode',$liste_periode)
            ->with('liste_categorie',$liste_categorie)
            ->with('liste_classe',$liste_classe)
            ->with('liste_pays',$liste_pays)
            ->with('liste_ville',$liste_ville)
            ->with('page_title',$page_title)
            ->with('eleve',$eleve);
    }

    public function postAdd($id = '')
    {
        //dd(Input::all());
        //Regles de validation
        $rules['sexe'] = 'required';
        $rules['nom'] = 'required';
        $rules['prenom'] = 'required';
        $rules['date_naissance'] = 'required';
        $rules['country_id'] = 'required';
        if( Input::get('country_id') != 79 ){
            $rules['autre_ville_naissance'] = 'required';
        } else {
            $rules['city_naissance_id'] = 'required';
        }
        $rules['quartier_naissance'] = 'required';
        $rules['prenom_pere'] = 'required';
        $rules['nom_mere'] = 'required';
        $rules['prenom_mere'] = 'required';
        $rules['city_id'] = 'required';
        $rules['quartier'] = 'required';
        $rules['email'] = 'email';
        $val = Validator::make(Input::all(),$rules);
        if($val->fails()) {
            return Redirect::to(Request::path())
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        } else {
            //Au cours d'une inscription
            if( empty($id) ){
                if( Input::get('periode_id') == 'choix' ){
                    return Redirect::to(Request::path())->with('error','Vous devez choisir une session')->withInput();
                }

                if( Input::get('category_id') == 'choix' ){
                    return Redirect::to(Request::path())->with('error','Vous devez choisir une catégorie')->withInput();
                }

                if( !Input::get('classroom_id') OR ( Input::has('classroom_id') AND Input::get('classroom_id') == 'choix') ){
                    return Redirect::to(Request::path())->with('error','Vous devez choisir une salle de classe')->withInput();
                }
            }

            if(!empty($id)){
                $eleve = Student::findOrFail($id);
                $msg = 'L\'élève a bien été modifié';
            } else {
                $eleve = new Student();
                $msg = 'L\'élève a bien été inscrit';
            }

            $eleve->sexe = Input::get('sexe');
            $eleve->nom = Input::get('nom');
            $eleve->prenom = Input::get('prenom');
            $eleve->date_naissance = Input::get('date_naissance');
            $eleve->country_id = Input::get('country_id');
            if( Input::get('country_id') != 79 ){
                $eleve->city_naissance_id = null;
                $eleve->autre_ville_naissance = Input::get('autre_ville_naissance');
            } else {
                $eleve->city_naissance_id = Input::get('city_naissance_id');
                $eleve->autre_ville_naissance = '';
            }
            $eleve->quartier_naissance = Input::get('quartier_naissance');
            $eleve->prenom_pere = Input::get('prenom_pere');
            $eleve->nom_mere = Input::get('nom_mere');
            $eleve->prenom_mere = Input::get('prenom_mere');
            $eleve->city_id = Input::get('city_id');
            $eleve->quartier = Input::get('quartier');
            $eleve->tel = Input::get('tel');
            $eleve->email = Input::get('email');
            $eleve->save();

            if( empty($id) ):
                //dans le cas d'une inscription, on affecte immediatement l'eleve a la classe et la session selectionnee
                if( Input::get('new') == 0 ){
                    Student::setHisClassroom($eleve->id,Input::get('classroom_id'),Input::get('periode_id'),'old');
                } else{
                    Student::setHisClassroom($eleve->id,Input::get('classroom_id'),Input::get('periode_id'));
                }

            else:
                //Definition de la session par defaut en fonction de la session envoye par le user

                    //On definit dabord toutes les autres sessions comme session de reinscription
                    DB::table('periode_student')
                        ->where('student_id','=',$id)
                        ->update(array('new' => 0));
                    if( Input::get('periode_id') != 'choix' ){
                        //Puis on definit Input::get('periode_id') comme session d'inscription
                        DB::table('periode_student')
                            ->where('periode_id','=',Input::get('periode_id'))
                            ->where('student_id','=',$id)
                            ->update(array('new' => 1 ));
                    }
            endif;

            //Si le user a choisi d'uploader une image
            if(Input::hasFile('userfile')){
                $image = Input::file('userfile');
                $path = public_path().'/assets/img/students';
                $file_name = $eleve->id.'_'.sha1($eleve->nom).'_'.str_random(20).'.'.$image->getClientOriginalExtension();

                //On verifie si la precende image existe on la supprime
                if( !empty($eleve->photo) AND file_exists(public_path().'/assets/img/students/'.$eleve->photo)){
                    unlink(public_path().'/assets/img/students/'.$eleve->photo);
                }

                if($image->move($path,$file_name)){
                    $eleve->photo = $file_name;
                    $eleve->save();
                }
            }

            return Redirect::to(Request::path())->with('success',$msg)->with('id',$eleve->id);
        }
    }

    public function getList()
    {
        //On recupere toutes les sessions
        $liste_periode =  array('choix'=>'Toutes');
        $query_periode =  Periode::orderBy('id')->get();
        foreach($query_periode as $p){
            $liste_periode[$p->id] = $p->interval;
        }


        //On recupere toutes les categories
        $liste_categorie =  array('choix'=>'Afficher tout');
        $query_categorie =  Category::orderBy('id')->get();
        foreach($query_categorie as $c){
            $liste_categorie[$c->id] = $c->nom;
        }

        //On recupere toutes les classes
        $liste_classe =  array('choix'=>'Afficher tout');
        $query_classe =  Classroom::orderBy('id')->get();
        foreach($query_classe as $c){
            $liste_classe[$c->id] = $c->nom;
        }


        $vue = View::make('student.list',compact('liste_periode','liste_categorie','liste_classe'));
        return $vue;
    }

    public function postList()
    {
        if( Request::ajax() ){

            if( Input::get('periode_id') != 'choix' ){
                Session::put('rechercheEleve.periode',Input::get('periode_id'));
            } else {
                Session::forget('rechercheEleve.periode');
            }

            if( Input::get('category_id') != 'choix' ){
                Session::put('rechercheEleve.category',Input::get('category_id'));
            } else {
                Session::forget('rechercheEleve.classroom');
                Session::forget('rechercheEleve.category');
            }

            if( Input::has('classroom_id') AND Input::get('classroom_id') != 'choix' ){
                Session::put('rechercheEleve.classroom',Input::get('classroom_id'));
            } else{
                Session::forget('rechercheEleve.classroom');
            }


            if( Input::has('nom') ){
                Session::put('rechercheEleve.nom',Input::get('nom'));
            } else {
                Session::forget('rechercheEleve.nom');
            }

            if( Input::has('filtre_scolarite') ){
                Session::put('rechercheEleve.filtre_scolarite',Input::get('filtre_scolarite'));
            } else {
                Session::forget('rechercheEleve.filtre_scolarite');
            }

            //=================================================================================================================
            if( Session::has('rechercheEleve.periode') )
            {
                if( Session::has('rechercheEleve.filtre_scolarite') ){
                    /*Le but est de faire une requete inverse. C'est a dire essayer de savoir depuis la table payment,
                    l'ensemble des eleves qui sont en regle. Puis on fait une requete dans la table des eleves
                    pour recupere les eleves qui ne sont pas ne regle en omettant les ID de ceux quui sont en regle
                    */
                    //On recupere la session
                    $periode = Periode::find(Session::get('rechercheEleve.periode'));
                    //Recuperation de tous les eleves en regle sur le payement
                    $list = Payment::select(DB::raw('student_id, sum(montant) as total_montant_paye'))
                        ->where('periode_id','=',$periode->id)
                        ->groupBy('student_id')
                        ->get();
                    if( count($list) > 0 ){ //Si il existe des eleves
                        //Alors on verifie par un filtre si ces eleves sont en regle
                        $list = $list->filter(function($e) use($periode) {
                            //Si l'eleve n'a pas de classe on le rejette car tout eleve netant pas inscrit dans une classe nest pas en regle
                            $classe = Student::getHisClassroom($e->student_id,$periode->id);
                            if( $classe != null ){
                                //On calcule le nbre de mois qu'il a paye
                                //On verifie dabord si la scolarite a ete definit specialement pr cet eleve
                                $scolarite = DB::table('periode_student')
                                    ->where('student_id','=',$e->student_id)
                                    ->where('periode_id','=',$periode->id)->pluck('scolarite');
                                if( empty($scolarite) ){
                                    $scolarite = DB::table('classroom_periode')
                                        ->where('classroom_id','=',$classe->id)
                                        ->where('periode_id','=',$periode->id)->pluck('scolarite');
                                    if( empty($scolarite) ){
                                        $scolarite = $periode->scolarite;
                                    }
                                }

                                $nbre_mois_paye = (int) ($e->total_montant_paye/$scolarite);

                                $annee_actuel = (int) date('Y');
                                $annee_debut_session = FormatDate::getSessionBorne($periode->interval);
                                if( $annee_actuel == $annee_debut_session){
                                    //Le mois actuelle doit etre superieur au mois de debut de payement
                                    if( ( ( (int) date('m') ) > ( (int) $periode->debut_payement ) ) ){
                                        $nbre_mois_devant_etre_paye = (int) ( ( (int) date('m') ) - ( (int) $periode->debut_payement ) );

                                        //Si le nbre de mois qu'il a paye est superieur u nbre de mois a payer
                                        //Alors ca veut dire qu'il est en regle
                                        if( $nbre_mois_paye == 9 OR ($nbre_mois_paye > $nbre_mois_devant_etre_paye) ){
                                            return $e;
                                        }
                                    }
                                } else if( $annee_actuel > $annee_debut_session){
                                    $nbre_mois_devant_etre_paye = ( (int) date('m') ) + 12 - ( (int) $periode->debut_payement ) + 1;

                                    //Si le nbre de mois qu'il a paye est superieur u nbre de mois a payer
                                    //Alors ca veut dire qu'il est en regle
                                    if( $nbre_mois_paye == 9 OR ($nbre_mois_paye > $nbre_mois_devant_etre_paye) ){
                                        return $e;
                                    }
                                }
                            }
                        });

                        //On enregistre les ID de tous les eleves non en regles pour les omettre dans la recherche
                        foreach( $list as $e) {
                            $liste_id[] = $e->student_id;
                        }

                    }
                }


                //Si cette variable de session existe (Session::has('rechercheEleve.filtre_scolarite'))
                //Alors ca veut dire que le user a declenche un filtre de recherche de scolarite
                if( Session::has('rechercheEleve.filtre_scolarite') AND count($list) > 0 ){
                    if( Session::has('rechercheEleve.category') )
                    {
                        if( Session::has('rechercheEleve.classroom') )
                        {
                            $liste_eleve = Student::whereHas('periodes',function($q){
                                $q->where('periode_id','=',Session::get('rechercheEleve.periode'))
                                    ->where('category_id','=',Session::get('rechercheEleve.category'))
                                    ->where('classroom_id','=',Session::get('rechercheEleve.classroom'));
                            })->whereNotIn('id',$liste_id);//On omet les ID des eleves en regle
                        }
                        else
                        {
                            $liste_eleve = Student::whereHas('periodes',function($q){
                                $q->where('periode_id','=',Session::get('rechercheEleve.periode'))
                                    ->where('category_id','=',Session::get('rechercheEleve.category'));
                            })->whereNotIn('id',$liste_id);//On omet les ID des eleves en regle
                        }
                    }
                    else
                    {
                        $liste_eleve = Student::whereHas('periodes',function($q){
                            $q->where('periode_id','=',Session::get('rechercheEleve.periode'));
                        })->whereNotIn('id',$liste_id);//On omet les ID des eleves en regle
                    }

                    if( Session::has('rechercheEleve.nom') ){
                        $liste_eleve = $liste_eleve->where('nom','like','%'.Session::get('rechercheEleve.nom').'%')
                            ->orWhere('prenom','like','%'.Session::get('rechercheEleve.nom').'%')
                            ->whereNotIn('id',$liste_id);//On omet les ID des eleves en regle
                    }
                } else {
                    if( Session::has('rechercheEleve.category') )
                    {
                        if( Session::has('rechercheEleve.classroom') )
                        {
                            $liste_eleve = Student::whereHas('periodes',function($q){
                                $q->where('periode_id','=',Session::get('rechercheEleve.periode'))
                                    ->where('category_id','=',Session::get('rechercheEleve.category'))
                                    ->where('classroom_id','=',Session::get('rechercheEleve.classroom'));
                            });
                        }
                        else
                        {
                            $liste_eleve = Student::whereHas('periodes',function($q){
                                $q->where('periode_id','=',Session::get('rechercheEleve.periode'))
                                    ->where('category_id','=',Session::get('rechercheEleve.category'));
                            });
                        }
                    }
                    else
                    {
                        $liste_eleve = Student::whereHas('periodes',function($q){
                            $q->where('periode_id','=',Session::get('rechercheEleve.periode'));
                        });
                    }

                    if( Session::has('rechercheEleve.nom') ){
                        $liste_eleve = $liste_eleve->where('nom','like','%'.Session::get('rechercheEleve.nom').'%')
                            ->orWhere('prenom','like','%'.Session::get('rechercheEleve.nom').'%');
                    }
                }

                $liste_eleve = $liste_eleve->orderBy('id','desc');
            }
            else if( Session::has('rechercheEleve.category') )
            {
                $liste_eleve = Student::whereHas('classrooms',function($q){
                    $q->where('category_id','=',Session::get('rechercheEleve.category'));
                });

                if( Session::has('rechercheEleve.classroom') )
                {
                    $liste_eleve = $liste_eleve->whereHas('classrooms',function($q){
                        $q->where('classroom_id','=',Session::get('rechercheEleve.classroom'));
                    });
                }

                if( Session::has('rechercheEleve.nom') ){
                    $liste_eleve = $liste_eleve->where('nom','like','%'.Session::get('rechercheEleve.nom').'%')
                        ->orWhere('prenom','like','%'.Session::get('rechercheEleve.nom').'%');
                }

                $liste_eleve = $liste_eleve->orderBy('id','desc');
            }
            else if( Session::has('rechercheEleve.nom') )
            {
                $liste_eleve = Student::where('nom','like','%'.Session::get('rechercheEleve.nom').'%')
                    ->orWhere('prenom','like','%'.Session::get('rechercheEleve.nom').'%')->orderBy('id','desc');
            } else{
                $liste_eleve = Student::orderBy('id','desc');
            }

            return View::make('student.listcontent')->with('liste_student',$liste_eleve->paginate(10));


            /*echo 'Session => '.Session::get('rechercheEleve.periode').'<br>';
            echo 'Categorie => '.Session::get('rechercheEleve.category').'<br>';
            echo 'Classe => '.Session::get('rechercheEleve.classroom').'<br>';
            echo 'Nom => '.Session::get('rechercheEleve.nom').'<br>';*/

        } else {
            exit;
        }
    }

    public function getListToPdf( $action = 'print' )
    {
        if( Session::has('rechercheEleve.periode') ) {
            if( Session::has('rechercheEleve.filtre_scolarite') ){
                /*Le but est de faire une requete inverse. C'est a dire essayer de savoir depuis la table payment,
                l'ensemble des eleves qui sont en regle. Puis on fait une requete dans la table des eleves
                pour recupere les eleves qui ne sont pas ne regle en omettant les ID de ceux quui sont en regle
                */
                //On recupere la session
                $periode = Periode::find(Session::get('rechercheEleve.periode'));
                //Recuperation de tous les eleves en regle sur le payement
                $list = Payment::select(DB::raw('student_id, sum(montant) as total_montant_paye'))
                    ->where('periode_id','=',$periode->id)
                    ->groupBy('student_id')
                    ->get();
                if( count($list) > 0 ){ //Si il existe des eleves
                    //Alors on verifie par un filtre si ces eleves sont en regle
                    $list = $list->filter(function($e) use($periode) {
                        //Si l'eleve n'a pas de classe on le rejette car tout eleve netant pas inscrit dans une classe nest pas en regle
                        $classe = Student::getHisClassroom($e->student_id,$periode->id);
                        if( $classe != null ){
                            //On calcule le nbre de mois qu'il a paye
                            //On verifie dabord si la scolarite a ete definit specialement pr cet eleve
                            $scolarite = DB::table('periode_student')
                                ->where('student_id','=',$e->student_id)
                                ->where('periode_id','=',$periode->id)->pluck('scolarite');
                            if( empty($scolarite) ){
                                $scolarite = DB::table('classroom_periode')
                                    ->where('classroom_id','=',$classe->id)
                                    ->where('periode_id','=',$periode->id)->pluck('scolarite');
                                if( empty($scolarite) ){
                                    $scolarite = $periode->scolarite;
                                }
                            }

                            $nbre_mois_paye = (int) ($e->total_montant_paye/$scolarite);

                            $annee_actuel = (int) date('Y');
                            $annee_debut_session = FormatDate::getSessionBorne($periode->interval);
                            if( $annee_actuel == $annee_debut_session){
                                //Le mois actuelle doit etre superieur au mois de debut de payement
                                if( ( ( (int) date('m') ) > ( (int) $periode->debut_payement ) ) ){
                                    $nbre_mois_devant_etre_paye = (int) ( ( (int) date('m') ) - ( (int) $periode->debut_payement ) );

                                    //Si le nbre de mois qu'il a paye est superieur u nbre de mois a payer
                                    //Alors ca veut dire qu'il est en regle
                                    if( $nbre_mois_paye == 9 OR ($nbre_mois_paye > $nbre_mois_devant_etre_paye) ){
                                        return $e;
                                    }
                                }
                            } else if( $annee_actuel > $annee_debut_session){
                                $nbre_mois_devant_etre_paye = ( (int) date('m') ) + 12 - ( (int) $periode->debut_payement ) + 1;

                                //Si le nbre de mois qu'il a paye est superieur u nbre de mois a payer
                                //Alors ca veut dire qu'il est en regle
                                if( $nbre_mois_paye == 9 OR ($nbre_mois_paye > $nbre_mois_devant_etre_paye) ){
                                    return $e;
                                }
                            }
                        }
                    });

                    //On enregistre les ID de tous les eleves non en regles pour les omettre dans la recherche
                    foreach( $list as $e) {
                        $liste_id[] = $e->student_id;
                    }
                }
            }


            //Si cette variable de session existe (Session::has('rechercheEleve.filtre_scolarite'))
            //Alors ca veut dire que le user a declenche un filtre de recherche de scolarite
            if( Session::has('rechercheEleve.filtre_scolarite') AND count($list) > 0 ){
                if( Session::has('rechercheEleve.category') )
                {
                    if( Session::has('rechercheEleve.classroom') )
                    {
                        $liste_eleve = Student::whereHas('periodes',function($q){
                            $q->where('periode_id','=',Session::get('rechercheEleve.periode'))
                                ->where('category_id','=',Session::get('rechercheEleve.category'))
                                ->where('classroom_id','=',Session::get('rechercheEleve.classroom'));
                        })->whereNotIn('id',$liste_id);//On omet les ID des eleves en regle
                    }
                    else
                    {
                        $liste_eleve = Student::whereHas('periodes',function($q){
                            $q->where('periode_id','=',Session::get('rechercheEleve.periode'))
                                ->where('category_id','=',Session::get('rechercheEleve.category'));
                        })->whereNotIn('id',$liste_id);//On omet les ID des eleves en regle
                    }
                }
                else
                {
                    $liste_eleve = Student::whereHas('periodes',function($q){
                        $q->where('periode_id','=',Session::get('rechercheEleve.periode'));
                    })->whereNotIn('id',$liste_id);//On omet les ID des eleves en regle
                }

                if( Session::has('rechercheEleve.nom') ){
                    $liste_eleve = $liste_eleve->where('nom','like','%'.Session::get('rechercheEleve.nom').'%')
                        ->orWhere('prenom','like','%'.Session::get('rechercheEleve.nom').'%')
                        ->whereNotIn('id',$liste_id);//On omet les ID des eleves en regle
                }
            } else {
                if( Session::has('rechercheEleve.category') )
                {
                    if( Session::has('rechercheEleve.classroom') )
                    {
                        $liste_eleve = Student::whereHas('periodes',function($q){
                            $q->where('periode_id','=',Session::get('rechercheEleve.periode'))
                                ->where('category_id','=',Session::get('rechercheEleve.category'))
                                ->where('classroom_id','=',Session::get('rechercheEleve.classroom'));
                        });
                    }
                    else
                    {
                        $liste_eleve = Student::whereHas('periodes',function($q){
                            $q->where('periode_id','=',Session::get('rechercheEleve.periode'))
                                ->where('category_id','=',Session::get('rechercheEleve.category'));
                        });
                    }
                }
                else
                {
                    $liste_eleve = Student::whereHas('periodes',function($q){
                        $q->where('periode_id','=',Session::get('rechercheEleve.periode'));
                    });
                }

                if( Session::has('rechercheEleve.nom') ){
                    $liste_eleve = $liste_eleve->where('nom','like','%'.Session::get('rechercheEleve.nom').'%')
                        ->orWhere('prenom','like','%'.Session::get('rechercheEleve.nom').'%');
                }
            }

            $liste_eleve = $liste_eleve->orderBy('id','desc');
        }
        else if( Session::has('rechercheEleve.category') )
        {
            $liste_eleve = Student::whereHas('classrooms',function($q){
                $q->where('category_id','=',Session::get('rechercheEleve.category'));
            });

            if( Session::has('rechercheEleve.classroom') )
            {
                $liste_eleve = $liste_eleve->whereHas('classrooms',function($q){
                    $q->where('classroom_id','=',Session::get('rechercheEleve.classroom'));
                });
            }

            if( Session::has('rechercheEleve.nom') ){
                $liste_eleve = $liste_eleve->where('nom','like','%'.Session::get('rechercheEleve.nom').'%')
                    ->orWhere('prenom','like','%'.Session::get('rechercheEleve.nom').'%');
            }

            $liste_eleve = $liste_eleve->orderBy('id','desc');
        }
        else if( Session::has('rechercheEleve.nom') )
        {
            $liste_eleve = Student::where('nom','like','%'.Session::get('rechercheEleve.nom').'%')
                ->orWhere('prenom','like','%'.Session::get('rechercheEleve.nom').'%')->orderBy('id','desc');
        } else{
            $liste_eleve = Student::orderBy('id','desc');
        }

        $html =  View::make('simpletpl')
            ->nest('child', 'student.listcontent',array('liste_student'=>$liste_eleve->get()));

        if( $action == 'save' ){
            return PDF::load($html, 'A4', 'landscape')->download('liste_eleve_'.snake_case(Ets::get('nom')));
        } else {
            return PDF::load($html, 'A4', 'landscape')->show();
        }
    }


    public function getReinscription( $student_id = '' )
    {
        $eleve = Student::findOrFail($student_id);

        //On recupere toutes les sessions
        $liste_periode =  array();
        $query_periode =  Periode::orderBy('id')->get();
        foreach($query_periode as $p){
            $liste_periode[$p->id] = $p->interval;
        }

        //On recupere toutes les categories
        $liste_categorie =  array();
        $query_categorie =  Category::orderBy('id')->get();
        foreach($query_categorie as $c){
            $liste_categorie[$c->id] = $c->nom;
        }

        //On recupere toutes les classes
        $liste_classe =  array();
        $query_classe =  Classroom::orderBy('id')->get();
        foreach($query_classe as $c){
            $liste_classe[$c->id] = $c->nom;
        }

        return View::make('student.reinscription',compact('eleve','liste_periode','liste_categorie','liste_classe'))
            ->withPageTitle('Réinscription d\'un élève');
    }

    public function postReinscription( $student_id = '' )
    {
        if( Request::ajax() ){
            $eleve = Student::find($student_id);
            $rules['periode_id'] = 'required|exists:periodes,id';
            $rules['category_id'] = 'required';
            $val = Validator::make(Input::all(),$rules);
            if($val->passes()){
                //Si l'eleve est deja inscrit a cette periode
                $liste_sessions = $eleve->periodes;
                if( $liste_sessions->contains(Input::get('periode_id')) )
                {
                    $classe = Student::getHisClassroom($student_id,Input::get('periode_id'));
                    //var_dump($classe->id);
                    //var_dump(Input::get('classroom_id'));
                    if($classe != null AND Input::get('classroom_id') == $classe->id ){
                        return '<div class="alert alert-danger" >L\'élève est déjà inscrit en classe '.$classe->nom.' pour la session '.Periode::find(Input::get('periode_id'))->interval.'</div>';
                    } else {
                        Student::setHisClassroom($eleve->id,$classe->id,Input::get('periode_id'),Input::get('classroom_id'));
                        return '<div class="alert alert-success" >L\'élève a bien été inscrit et affecté en classe '.Classroom::find(Input::get('classroom_id'))->nom.' pour la session '.Periode::find(Input::get('periode_id'))->interval.'</div>';
                    }
                } else{
                    Student::setHisClassroom($eleve->id,Input::get('classroom_id'),Input::get('periode_id'));
                    return '<div class="alert alert-success" >L\'élève a été inscrit avec succès</div>';
                }

            } else {
                return '<div class="alert alert-danger" >'.current($val->messages()->all()).'</div>';
            }
        } else{
            exit;
        }
    }

    public function postDesinscription( $student_id, $periode_id)
    {
        $student = Student::findOrFail($student_id);
        $periode = Periode::findOrFail($periode_id);
        DB::table('periode_student')->where('student_id','=',$student_id)->where('periode_id','=',$periode_id)->delete();
        DB::table('classroom_student')->where('student_id','=',$student_id)->where('periode_id','=',$periode_id)->delete();
        DB::table('payments')->where('student_id','=',$student_id)->where('periode_id','=',$periode_id)->delete();
        return Redirect::to('student/list')
            ->with('success','L\'élève '.$student->prenom.' '.$student->nom.' a bien été désinscrit de la session '.$periode->interval);
    }

    public function getDelete( $student_id = '' )
    {
        if( CurrentUser::is_admin() == false ){
            return UserAccess::just_for_admin();
        }

        $student = Student::findOrFail($student_id);
        DB::table('periode_student')->where('student_id','=',$student_id)->delete();
        DB::table('classroom_student')->where('student_id','=',$student_id)->delete();
        DB::table('payments')->where('student_id','=',$student_id)->delete();
        $student->delete();
        return Redirect::to('student/list')->with('success','L\'élève '.$student->prenom.' '.$student->nom.' a bien été supprimé');
    }

    public function postGetListeClassroom($defaul = '', $classe_par_defaut_id = ''){
        if( Request::ajax() ){
            if( Input::get('category_id') == 'choix' ) {
                echo Form::label('classroom_id','Classe');
                echo Form::select('classroom_id',array('choix'=>'Affihcer tout'),null,array('class'=>'form-control','disabled'=>'disabled'));
            } else {
                $liste_classe = array();
                if( !empty($defaul) ){
                    $liste_classe['choix'] = 'Choisir une classe';
                }

                $categorie = Category::findOrFail(Input::get('category_id'));
                if( $categorie != null){
                    //Si le user a choisi une session on fait la requete en fonction de la session et la categorie
                    if( Input::get('periode_id') != 'choix' ){
                        $query_classe = Classroom::whereHas('periodes',function($q){
                            $q->where('periode_id','=',Input::get('periode_id'));
                        })->where('category_id','=',Input::get('category_id'))->get();
                    } else { //Sinon on fait la requete en fonction de la categorie
                        $query_classe = Classroom::where('category_id','=',Input::get('category_id'))->get();
                    }

                    if( count($query_classe) > 0 ){
                        foreach( $query_classe as $c){
                            $liste_classe[$c->id] = $c->nom;
                        }

                        echo Form::label('classroom_id','Classe');
                        if( !empty($classe_par_defaut_id) AND $classe_par_defaut_id != 'choix' ){
                            echo Form::select('classroom_id',$liste_classe,$classe_par_defaut_id,array('class'=>'form-control'));
                        } else {
                            echo Form::select('classroom_id',$liste_classe,null,array('class'=>'form-control'));
                        }
                    } else{
                        echo Form::label('classroom_id','Classe');
                        echo '<br>Aucune salle de classe dans cette catégorie '.$categorie->nom;
                    }
                }
                else{
                    exit;
                }
            }
        } else {
            exit;
        }
    }

    public function postGetListePeriode( $student_id = '' ){
        if( Request::ajax() )
        {
            $liste_periode = array('choix'=>'Choisir une session');
            $periodes = Student::find($student_id)->periodes;
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

    public function postGetPeriodeScolarite(){
        if( Input::get('periode_id') != 'choix' ){
            $frais_scolarite = DB::table('periode_student')
                ->where('student_id',Input::get('student_id'))
                ->where('periode_id',Input::get('periode_id'))->pluck('scolarite');
            if( $frais_scolarite != ''){
                echo $frais_scolarite;
            } else {
                $classe = Student::getHisClassroom(Input::get('student_id'),Input::get('periode_id'));
                $frais_scolarite = DB::table('classroom_periode')
                    ->where('classroom_id',$classe->id)
                    ->where('periode_id',Input::get('periode_id'))->pluck('scolarite');
                if( $frais_scolarite != '' ){
                    echo $frais_scolarite;
                } else {
                    echo Periode::find(Input::get('periode_id'))->scolarite;
                }
            }
        }
    }

    public function postSetPeriodeScolarite()
    {
        if( CurrentUser::is_admin() == false ){
            return UserAccess::just_for_admin();
        }

        $rule = array(
            'define_payment_scolarite' => 'numeric'
        );

        $val = Validator::make(Input::all(),$rule);
        if( $val->passes() ){
            $e = Student::find(Input::get('student_id'));
            $p = Periode::find(Input::get('periode_id'));
            DB::table('periode_student')
                ->where('student_id','=',Input::get('student_id'))
                ->where('periode_id','=',Input::get('periode_id'))->update(array(
                    'scolarite'=>Input::get('define_payment_scolarite')
                ));

            if( Input::get('define_payment_scolarite') == '' ){
                $msg = 'Les frais de scolarité de l\'élève '.$e->prenom.' '.$e->nom.' pour la session '.$p->interval.' ont été réinitialisés';
            }else{
                $msg = 'Les frais de scolarité de l\'élève '.$e->prenom.' '.$e->nom.' pour la session '.$p->interval.' s\'élèvent maintenant à '.Input::get('define_payment_scolarite').' '.Ets::get('devise');
            }
            return \Illuminate\Support\Facades\Redirect::to(Input::get('back'))
                ->with('success',$msg);
        } else {
            return \Illuminate\Support\Facades\Redirect::to(Input::get('back'))
                ->with('error','Vous devez choisir un nombre.');
        }
    }




}