<?php
class Country extends Eloquent {

    public function students()
    {
        return $this->hasMany('Student');
    }

}