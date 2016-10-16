<?php

class PaymentController extends BaseController {


    public function getIndex(){
        return Redirect::to('student/list');
    }

    public function getList( $tudent_id = '', $periode_id = '')
    {
        $eleve = Student::find($tudent_id);

        //On verife si le user a choisi une session, on la met comme session active de payement
        if( !empty($periode_id) ){
            Session::put('payment.periode',$periode_id);
        } else {
            Session::put('payment.periode',Periode::where('actif','=','oui')->first()->id);
        }

        $eleve = Student::find($tudent_id);
        $classe = Student::getHisClassroom($tudent_id,Session::get('payment.periode'));
        $periode = Periode::find(Session::get('payment.periode'));
        if( $periode == null){
            $msg = 'Vous devez choisir une session valide.';
            return Redirect::to('student/list')
                ->with('error',$msg);
        }
        //Un eleve ne peut exister sans une salle de classe et une session
        if( $classe == null){
            $msg = 'Vous ne pouvez pas accéder aux frais de scolarité de l\'élève <b>'.$eleve->prenom.' '.$eleve->nom.'</b> car il n\'est pas inscrit pour la session <b>'.$periode->interval.'</b>';
            return Redirect::to('student/list')
                ->with('eleve_non_inscrit',$msg)
                ->with('student_id',$tudent_id);
        }


        //On recupere toutes les sessions
        $liste_periode =  array('choix'=>'Toutes');
        $query_periode =  Periode::orderBy('id')->get();
        foreach($query_periode as $p){
            $liste_periode[$p->id] = $p->interval;
        }

        $montant = Payment::where('student_id','=',$eleve->id)
            ->where('periode_id','=',Session::get('payment.periode'))->sum('montant');

        //Recuperation du motant de la scolarite
        //On verifie si la scolarite a ete definit specialement pr cet eleve
        $query_frais_scolarite = DB::table('periode_student')
            ->where('student_id','=',$eleve->id)
            ->where('periode_id','=',$periode->id)->pluck('scolarite');
        if( !empty($query_frais_scolarite) ){
            $montant_frais_scolarite = $query_frais_scolarite;
        } else{
            //On verifie si la scolarite a ete definit specialement pr la classe de cet eleve
            $query_frais_scolarite = DB::table('classroom_periode')
                ->where('classroom_id','=',$classe->id)
                ->where('periode_id','=',$periode->id)->pluck('scolarite');
            if( !empty($query_frais_scolarite) ){
                $montant_frais_scolarite = $query_frais_scolarite;
            }else{
                $montant_frais_scolarite = $periode->scolarite;
            }
        }
        //===============================================================================

        $reliquat = ($montant_frais_scolarite*9) - $montant;
        $nbre_mois_paye = $montant/$montant_frais_scolarite;
        $nbre_mois_paye = (int) $nbre_mois_paye;

        $liste_payment = Payment::where('student_id','=',$tudent_id)
            ->where('periode_id','=',Session::get('payment.periode'))->get();

        return View::make('payment.list',compact(
            'classe',
            'liste_periode',
            'liste_payment',
            'eleve',
            'periode',
            'montant',
            'montant_frais_scolarite',
            'reliquat',
            'nbre_mois_paye'));
    }

    public function postProcess( $student_id = '', $session_id = '')
    {
        $redirection =  Redirect::to('payment/list/'.$student_id);
        $eleve = Student::findOrFail($student_id);
        $classe = Student::getHisClassroom($student_id,$session_id);
        if( $classe == null ){//Si l'effect na pas de classe pour cette session on renvoi
            return $redirection->with('error','Impossible d\'effectuer le payement car cet élève n\'est affecté à aucunne classe pour la session encours.');
        }

        $rules['montant'] = 'required|numeric';
        $val = Validator::make(Input::all(),$rules);
        if( $val->passes() ){
            $payment = new Payment();
            $payment->student_id = $student_id;
            $payment->periode_id = $session_id;
            $payment->montant = Input::get('montant');
            $payment->save();
            return $redirection->with('success','Le payement a bien été effectuté');
        } else {
            return $redirection->withInput()->withErrors($val)
            ->with('error',current($val->messages()->all()));
        }

    }

    public function postEdit( $payment_id, $student_id ){
        $student = Student::findOrFail($student_id);
        $payment = Payment::findOrFail($payment_id);
        $payment->montant = Input::get('montant');
        $payment->save();

        return Redirect::to('payment/list/'.$student_id)->with('success','Le payement du '.FormatDate::lettres($payment->created_at).' a bient été modifié au montant '.Input::get('montant').' GNF');
    }

    public function getDelete( $payment_id, $student_id ){
        $student = Student::findOrFail($student_id);
        $payment = Payment::findOrFail($payment_id);
        $payment->delete();

        return Redirect::to('payment/list/'.$student_id)->with('success','Le payement du '.FormatDate::lettres($payment->created_at).' a bient été supprimé');
    }


}