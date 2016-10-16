<?php
class City extends Eloquent {

    public function students()
    {
        return $this->hasMany('Student','city_naissance_id');
    }

    public function students_that_live()
    {
        return $this->hasMany('Student');
    }

}