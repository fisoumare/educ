<?php
class Cloture extends Eloquent {

    public static function IsClotured($date)
    {
        $date = explode(' ',$date);
        $nbre_cloture = Cloture::where('date_cloture',$date[0])->count();
        if($nbre_cloture > 0){
            return true;
        }
        else{
            return false;
        }
    }
}