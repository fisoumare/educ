<?php
class Student extends Eloquent {

    public function payments()
    {
        return $this->hasMany('Payment');
    }

    public function country()
    {
        return $this->belongsTo('Country');
    }

    public function city()
    {
        return $this->belongsTo('City','city_naissance_id');
    }

    public function classrooms(){
        return $this->belongsToMany('Classroom')->withPivot('periode_id');
    }

    public function periodes(){
        return $this->belongsToMany('Periode')->withPivot('classroom_id','category_id')->withTimestamps();
    }

    //Cette methode donne la classe a lakel appartient un eleve
    public static function getHisClassroom( $student_id, $session_id )
    {
        $classroom_id = DB::table('classroom_student')->where('student_id','=',$student_id)
            ->where('periode_id','=',$session_id)
            ->pluck('classroom_id');

        return Classroom::find($classroom_id);
    }

    /*Cette fonction affecte un eleve a une classe et une session
    1 - Si la vairable $new_classroom_id est renseignee et est un entier alors l'eleve est affectee de la classe dont
        l'iD correspond a $classroom_id vers la classe dont l'ID correspond a ce entier sans changer de session
    2 - Si la vairable $new_classroom_id est renseignee et vaut :
        a) 'new' ==> alors il sagit de l'inscription dun nouvel eleve
        b) 'old' ==> alors il sagit de l'inscription dun ancien eleve
    3 - Si la variable nest pas renseignee alors l'eleve est affectee dans la classe dont
        l'iD correspond a $classroom_id
    */
    public static function setHisClassroom( $student_id, $classroom_id, $session_id, $new_classroom_id = '')
    {
        if( !empty($new_classroom_id) AND is_integer($new_classroom_id) ){
            $classe = Classroom::find($new_classroom_id);
            DB::table('periode_student')->where('periode_id','=',$session_id)->where('student_id','=',$student_id)
                ->where('classroom_id','=',$classroom_id)->update(array(
                    'classroom_id' => $new_classroom_id,
                    'category_id'=>$classe->category_id,
                    'new'=> 0
                ));

            DB::table('classroom_student')->where('periode_id','=',$session_id)->where('student_id','=',$student_id)
                ->where('classroom_id','=',$classroom_id)->update(array(
                    'classroom_id' => $new_classroom_id));

            //AVEC LA NOUVELLE CLASSE======================================================================================
            //On verifie si la classe n'est pas liée à la période en question, alors on les lie
            $lien = DB::table('classroom_periode')
                ->where('classroom_id','=',$new_classroom_id)
                ->where('periode_id','=',$session_id)->count();

            if( $lien == 0 ) {
                DB::table('classroom_periode')->insert(array(
                    'classroom_id' => $new_classroom_id,
                    'periode_id' => $session_id));
            }


        } else {
            $classe = Classroom::find($classroom_id);
            if( !empty($new_classroom_id) AND $new_classroom_id == 'old' ){
                DB::table('periode_student')->insert(array(
                    'periode_id' => $session_id,
                    'student_id' => $student_id,
                    'classroom_id' => $classroom_id,
                    'category_id'=>$classe->category_id,
                    'new'=>0
                ));
            } else {
                DB::table('periode_student')->insert(array(
                    'periode_id' => $session_id,
                    'student_id' => $student_id,
                    'classroom_id' => $classroom_id,
                    'category_id'=>$classe->category_id));
            }

            DB::table('classroom_student')->insert(array(
                'classroom_id' => $classroom_id,
                    'student_id' => $student_id,
                    'periode_id' => $session_id));

            //On verifie si la classe n'est pas liée encore à la période en question, alors on les lie
            $lien = DB::table('classroom_periode')
                ->where('classroom_id','=',$classroom_id)
                ->where('periode_id','=',$session_id)->count();

            if( $lien == 0 ) {
                DB::table('classroom_periode')->insert(array(
                    'classroom_id' => $classroom_id,
                    'periode_id' => $session_id));
            }
        }
    }


    public static function checkHisClassroom($student_id, $classroom_id, $session_id){
        $check_periode = DB::table('periode_student')
            ->where('periode_id','=',$session_id)->where('student_id','=',$student_id)
            ->where('classroom_id','=',$classroom_id)->first();

        $check_classroom = DB::table('classroom_student')->where('periode_id','=',$session_id)
            ->where('student_id','=',$student_id)
            ->where('classroom_id','=',$classroom_id)->first();
        if( $check_periode != null AND $check_classroom != null ) {
            return true;
        } else {
            return false;
        }
    }


}