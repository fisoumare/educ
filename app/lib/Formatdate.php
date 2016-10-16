<?php  
class FormatDate
{
    public static function getSession( $min_year = 1970){
        $result = array();
        for( $date = date('Y'); $date >= $min_year; $date-- ){
            $result[$date.' - '.($date+1)] = $date.' - '.($date+1);
        }
        return $result;
    }

    public static function getSessionBorne($interval, $param = 'left')
    {
        $date_entiere = (string) $interval;
        $date_entiere = explode('-',$date_entiere);
        $left = (int) trim($date_entiere[0]);
        $right = (int) trim($date_entiere[1]);
        if( $param == 'left')
        {
            return $left;
        } else {
            return $right;
        }
    }

    public static function getSessionStarting($date, $param = 'mois')
    {
        $date = (string) $date;
        $date_entiere = explode('/',$date);
        $jour = $date_entiere[0];
        $mois = $date_entiere[1];
        $annee = $date_entiere[2];
        if( $param == 'mois')
        {
            return $mois;
        } else if( $param == 'jour'){
            return $jour;
        } else {
            return $annee;
        }

    }

    public static function getSessionMonthsList($session_debut, $session_fin)
    {
        $data = array();
        $liste_mois = array(
            '1'=>'Janvier',
            '2'=>'Février',
            '3'=>'Mars',
            '4'=>'Avril',
            '5'=>'Mai',
            '6'=>'Juin',
            '7'=>'Juillet',
            '8'=>'Aout',
            '9'=>'Septembre',
            '10'=>'Octobre',
            '11'=>'Novembre',
            '12'=>'Décembre'
        );

        $explode_debut = explode('/',$session_debut);
        $explode_fin = explode('/',$session_fin);

        $mois_debut = (int) $session_debut[1];
        $annee_debut = $session_debut[2];

        $mois_fin = (int) $session_fin[1];
        $annee_fin = $session_fin[2];

        //Si la session debute et finit dans la meme annee
        if( $annee_debut == $annee_fin ){
            for( $i = $mois_debut; $i <= $mois_fin; $i++){
                $data[$i] = $liste_mois[$i];
            }
        } else {
            for( $i = $mois_debut; $i <= 12; $i++){
                $data[$i] = $liste_mois[$i];
            }

            for( $i = 1; $i <= $mois_fin; $i++){
                $data[$i] = $liste_mois[$i];
            }
        }
        return $data;
    }

    /*
    *Converti une date en lettre 
    */
    public static function lettres($date,$choix_affichage_de_lheure=false)
    {
        $liste_mois = array(
        '01'=>'Janvier',
        '02'=>'Février',
        '03'=>'Mars',
        '04'=>'Avril',
        '05'=>'Mai',
        '06'=>'Juin',
        '07'=>'Juillet',
        '08'=>'Aout',
        '09'=>'Septembre',
        '10'=>'Octobre',
        '11'=>'Novembre',
        '12'=>'Décembre'
        );  
        
        if(!empty($date))
        {
            /*La date peut parfois etre composee de de la date separe par l'heure par un espace
            donc on verifie dabor la presence de l'heure*/
            $date_entiere = explode(' ',$date);
            if(isset($date_entiere[1]))
            {
                if($choix_affichage_de_lheure==false)
                {
                    $heure = '';    
                }
                else
                {
                    $heure = ' &agrave '.$date_entiere[1];
                }
            }
            else
            {
                $heure = '';
            }
            
            $element_date = explode('-',$date_entiere[0]);
            $jour = $element_date[2];    
            $mois = $element_date[1]; 
            $annee = (int) $element_date[0]; 
            
            if($annee != 0)
            {                           
                return $jour.' '.$liste_mois[$mois].' '.$annee.''.$heure;   
            }
            else
            {
                return 'Format non valide';   
            }
        }        
        else
        {
            return '';
        }   
    }
    
    public static function chiffres($date)
    {
        if(!empty($date))
        {
            $element_date = explode('-',$date);
            $data['jour'] = (int) $element_date[2];    
            $data['mois'] = (int) $element_date[1]; 
            $data['annee'] = (int) $element_date[0]; 

            return $data; 
        }  
        else
        {
            return '';
        }    
    }     
    
    public static function barres($date)
    {
        if(!empty($date))
        {
            $element_date = explode('-',$date);
            $data['jour'] = $element_date[2];    
            $data['mois'] = $element_date[1]; 
            $data['annee'] = $element_date[0]; 

            return $data['jour'].'/'.$data['mois'].'/'.$data['annee'];  
        }  
        else
        {
            return '';
        }    
    }    
    
    public static function BDD($date)
    {
        if(!empty($date))
        {
            $element_date = explode('/',$date);
            $jour = (int) $element_date[0];    
            $mois = (int) $element_date[1]; 
            $annee = (int) $element_date[2]; 

            return $annee.'-'.$mois.'-'.$jour; 
        }  
        else
        {
            return '';
        }    
    }

    public static function jour_semaine($jour,$mois,$annee,$type='')
    {

        $jour = (int) $jour;

        $jours_semaine = array(
            0=>'dimanche',
            1=>'lundi',
            2=>'mardi',
            3=>'mercredi',
            4=>'jeudi',
            5=>'vendredi',
            6=>'samedi'
        );

        $jours_semaine_court = array(
            0=>'Dim',
            1=>'Lun',
            2=>'Mar',
            3=>'Mer',
            4=>'Jeu',
            5=>'Ven',
            6=>'Sam'
        );

        //On essaye ici de savoir le premier du mois correspond a kel jour de la semaine
        $timestamp_du_premier_jour = gmmktime(0,0,0,$mois,$jour,$annee);

        $liste_jours = getdate($timestamp_du_premier_jour);
        $numero_du_jour = $liste_jours['wday'];

        if(!empty($type) && $type == 'short')
        {
            return $jours_semaine_court[$numero_du_jour];
        }
        else {
            return $jours_semaine[$numero_du_jour];
        }
    }


    /*
     * Cette retourne un tableau contenant toutes les semaines contenues dans un mois
     * (la liste des jours de chaque semaine es contenu dans un tableau)
     * */
    public static function semaines_du_mois($mois,$annee)
    {
        $jours_semaine = array(
            'lundi'=>1,
            'mardi'=>2,
            'mercredi'=>3,
            'jeudi'=>4,
            'vendredi'=>5,
            'samedi'=>6,
            'dimanche'=>7
        );

        //On va d'abord essayer de savoir combien de jours on a dans le mois correspondant
        $nbre_de_jours = days_in_month($mois,$annee);
        $debut_du_mois = $jours_semaine[jour_semaine(1,$mois,$annee)];

        $nbre_jours_semaine_1 = 8 - $debut_du_mois;
        $nbre_jours_semaine_2 = 7;
        $nbre_jours_semaine_3 = 7;
        $nbre_jours_semaine_4 = 7;

        if($nbre_de_jours == 28)
        {
            if($nbre_jours_semaine_1 < 7)
            {
                $nbre_jours_semaine_5 = 7 - $nbre_jours_semaine_1;
            }
        }
        else if($nbre_de_jours == 29)
        {
            $nbre_jours_semaine_5 = 7 - $nbre_jours_semaine_1;
        }
        else if($nbre_de_jours == 30)
        {
            if($nbre_jours_semaine_1 == 1)
            {
                $nbre_jours_semaine_5 = 7;
                $nbre_jours_semaine_6 = 1;
            }
            else
            {
                $nbre_jours_semaine_5 = 9 - $nbre_jours_semaine_1;
            }
        }
        else
        {
            if($nbre_jours_semaine_1 <= 2)
            {
                $nbre_jours_semaine_5 = 7;
                $nbre_jours_semaine_6 = 3 - $nbre_jours_semaine_1;
            }
            else
            {
                $nbre_jours_semaine_5 = 10 - $nbre_jours_semaine_1;
            }
        }

        //====================================================================
        if(!empty($nbre_jours_semaine_1))
        {
            for($i = 1; $i <= $nbre_jours_semaine_1; $i++)
            {
                $data_semainre_1[$i] = jour_semaine($i, $mois, $annee);
            }

            $liste_semaines[1] = $data_semainre_1;
        }

        //====================================================================
        if(!empty($nbre_jours_semaine_2))
        {
            for($i = $nbre_jours_semaine_1 + 1; $i <= $nbre_jours_semaine_1 + 7; $i++)
            {
                $data_semainre_2[$i] = jour_semaine($i, $mois, $annee);
            }

            $liste_semaines[2] = $data_semainre_2;
        }

        //====================================================================
        if(!empty($nbre_jours_semaine_3))
        {
            for($i = $nbre_jours_semaine_1 + 8; $i <= $nbre_jours_semaine_1 + 14; $i++)
            {
                $data_semainre_3[$i] = jour_semaine($i, $mois, $annee);
            }

            $liste_semaines[3] = $data_semainre_3;
        }

        //====================================================================
        if(!empty($nbre_jours_semaine_4))
        {
            for($i = $nbre_jours_semaine_1 + 15; $i <= $nbre_jours_semaine_1 + 21; $i++)
            {
                $data_semainre_4[$i] = jour_semaine($i, $mois, $annee);
            }

            $liste_semaines[4] = $data_semainre_4;
        }

        //====================================================================
        if(!empty($nbre_jours_semaine_5))
        {
            for($i = $nbre_jours_semaine_1 + 22; $i <= $nbre_jours_semaine_1 + 21 + $nbre_jours_semaine_5; $i++)
            {
                $data_semainre_5[$i] = jour_semaine($i, $mois, $annee);
            }

            $liste_semaines[5] = $data_semainre_5;
        }

        //====================================================================
        if(!empty($nbre_jours_semaine_6))
        {
            for($i = $nbre_jours_semaine_1 + 21 + $nbre_jours_semaine_5 + 1; $i <= $nbre_jours_semaine_1 + 21 + $nbre_jours_semaine_5 + $nbre_jours_semaine_6; $i++)
            {
                $data_semainre_6[$i] = jour_semaine($i, $mois, $annee);
            }

            $liste_semaines[6] = $data_semainre_6;
        }

        return $liste_semaines;
    }

    public static function annee($key = '', $value = '')
    {
        if( !empty($key) AND !empty($value) ){
            $data[$key] = $value;
        }

        for( $i=date('Y'); $i>=1900; $i--){
            $data[$i] = $i;
        }

        return$data;
    }

    public static function mois($key = '', $value = '')
    {
        if( !empty($key) AND !empty($value) ){
            $data[$key] = $value;
        }

        $data['01'] ='Janvier';
        $data['02'] ='Février';
        $data['03'] ='Mars';
        $data['04'] ='Avril';
        $data['05'] ='Mai';
        $data['06'] ='Juin';
        $data['07'] ='Juillet';
        $data['08'] ='Août';
        $data['09'] ='Septembre';
        $data['10'] ='Octobre';
        $data['11'] ='Novembre';
        $data['12'] ='Décembre';
        return $data;
    }

    public static function jours_du_mois($key = '', $value = ''){
        if( !empty($key) AND !empty($value) ){
            $data[$key] = $value;
        }

        for( $i=1; $i<=31; $i++){
            if( $i<10){
                $data['0'.$i] = '0'.$i;
            }
            else{
                $data[$i] = $i;
            }
        }

        return$data;
    }

    public static function mois_prochain($mois_em_cours)
    {
        $mois_en_cours = (int) $mois_em_cours;
        if($mois_em_cours == 12){
            return '01';
        }
        else{
            $mois_prochain = $mois_em_cours + 1;
            if($mois_prochain < 10){
                return '0'.$mois_prochain;
            }
            else{
                return $mois_prochain;
            }
        }
    }


    //Cette fonction verifie si deux dqte sont identiques
    public static function identique($date_1,$date_2,$choix_affichage_de_lheure=false)
    {
        $liste_mois = array(
            '01'=>'Janvier',
            '02'=>'Février',
            '03'=>'Mars',
            '04'=>'Avril',
            '05'=>'Mai',
            '06'=>'Juin',
            '07'=>'Juillet',
            '08'=>'Aout',
            '09'=>'Septembre',
            '10'=>'Octobre',
            '11'=>'Novembre',
            '12'=>'Décembre'
        );

        /*La date peut parfois etre composee de de la date separe par l'heure par un espace
        donc on verifie dabor la presence de l'heure*/
        $date_entiere_1 = explode(' ',$date_1);
        $date_entiere_2 = explode(' ',$date_2);
        if( $date_entiere_1[0] == $date_entiere_2[0] ) {
            return true;
        }
        else{
            return false;
        }
    }

    public static function timestamp( $date )
    {
        $new_date = FormatDate::chiffres($date);

        return $timestamp_date = gmmktime(0,0,0,$new_date['mois'],$new_date['jour'],$new_date['annee']);
    }

    public static function moisEnTableau( $type = false )
    {
        $data['01'] ='Janvier';
        $data['02'] ='Février';
        $data['03'] ='Mars';
        $data['04'] ='Avril';
        $data['05'] ='Mai';
        $data['06'] ='Juin';
        $data['07'] ='Juillet';
        $data['08'] ='Août';
        $data['09'] ='Septembre';
        $data['10'] ='Octobre';
        $data['11'] ='Novembre';
        $data['12'] ='Décembre';

        $data_2[] ='Janvier';
        $data_2[] ='Février';
        $data_2[] ='Mars';
        $data_2[] ='Avril';
        $data_2[] ='Mai';
        $data_2[] ='Juin';
        $data_2[] ='Juillet';
        $data_2[] ='Août';
        $data_2[] ='Septembre';
        $data_2[] ='Octobre';
        $data_2[] ='Novembre';
        $data_2[] ='Décembre';

        if( $type == true ){
            return $data;
        } else {
            return $data_2;
        }
    }

    public static function diff_jour($debut,$fin)
    {
            $debut = strtotime(FormatDate::BDD($debut));
            $fin = strtotime(FormatDate::BDD($fin));
            return (abs($debut-$fin))/86400;
    }
}


