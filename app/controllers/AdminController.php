<?php

class AdminController extends BaseController {

    public function getIndex()
    {
        return Redirect::to('admin/dashboard');
    }
    
    public function getDashboard()
    {
        if( CurrentUser::is_admin() == false ){
            return \Illuminate\Support\Facades\Redirect::to('student');
        }

        $revenu = 0;
        $revenu_inscription = 0;
        $revenu_reinscription = 0;
        $nbre_eleve = 0;
        $nbre_eleve_garcon = 0;
        $nbre_eleve_fille = 0;

        $current_periode = Periode::where('actif','=','oui')->first();
        if( $current_periode != null ){
            $nbre_eleve = $current_periode->students()->count();
            $nbre_eleve_garcon = $current_periode->students()->where('sexe','m')->count();
            $nbre_eleve_fille = $current_periode->students()->where('sexe','f')->count();
            $revenu = Payment::where('periode_id',$current_periode->id)->sum('montant');

            //On recupere le montant des inscriptions
            $revenu_inscription = 0;
            $liste_inscrits = DB::table('periode_student')->where('periode_id',$current_periode->id)->get();
            if( $liste_inscrits != null ){
                foreach( $liste_inscrits as $e){
                    if( $e->new == 1 ){
                        $revenu_inscription += $current_periode->montant_inscription;
                    } else {
                        $revenu_reinscription += $current_periode->montant_reinscription;
                    }
                }
            }
        }


        return View::make('admin.dashboard')
            ->with('current_periode',$current_periode)
            ->with('revenu',$revenu)
            ->with('revenu_inscription',$revenu_inscription)
            ->with('revenu_reinscription',$revenu_reinscription)
            ->with('nbre_eleve',$nbre_eleve)
            ->with('nbre_eleve_garcon',$nbre_eleve_garcon)
            ->with('nbre_eleve_fille',$nbre_eleve_fille);
    }

    public function getSettings( $mode = 'view' )
    {
        if( CurrentUser::is_admin() == false ){
            return UserAccess::just_for_admin();
        }

        $config = DB::table('config')->first();
        return View::make('admin.settings')->with('config',$config)->with('titre_page','Paramètres');
    }

    public function postSettings()
    {
        if( CurrentUser::is_admin() == false ){
            return UserAccess::just_for_admin();
        }

        $val = Validator::make(
            Input::all(),
            array(
                'nom' => 'required|max:2000',
                'adresse' => 'required|max:2000',
                'tel' => 'required|max:255',
                'email' => 'required|max:255',
                'scolarite' => 'required|max:255',
                'devise' => 'required|max:20',
                'montant_inscription' => 'required|numeric',
                'montant_reinscription' => 'required|numeric'
            )
        );

        if( $val->fails() ){
            return Redirect::to('admin/settings/update')
                ->with('liste_erreurs',$val->messages())
                ->withErrors($val)
                ->withInput();
        }
        else{
            $config['nom'] = Input::get('nom');
            $config['adresse'] = Input::get('adresse');
            $config['tel'] = Input::get('tel');
            $config['email'] = Input::get('email');
            $config['scolarite'] = Input::get('scolarite');
            $config['devise'] = Input::get('devise');
            $config['montant_inscription'] = Input::get('montant_inscription');
            $config['montant_reinscription'] = Input::get('montant_reinscription');

            DB::table('config')->update($config);

            //Si le user a choisi d'uploader une image
            if(Input::hasFile('userfile')){
                $image = Input::file('userfile');
                $path = public_path().'/assets/img';
                $file_name = sha1($config['nom']).'_'.str_random(20).'.'.$image->getClientOriginalExtension();

                $app_config = DB::table('config')->first();

                //On verifie si la precende image existe on la supprime
                if( !empty($app_config->photo) AND file_exists(public_path().'/assets/img/'.$app_config->photo)){
                    unlink(public_path().'/assets/img/'.$app_config->photo);
                }

                if($image->move($path,$file_name)){
                    $config['photo'] = $file_name;
                    DB::table('config')->update($config);
                }
            }

            return \Illuminate\Support\Facades\Redirect::to('admin/settings')
                ->with('success','Les paramètres ont bien été enregistrés');
        }
    }
}