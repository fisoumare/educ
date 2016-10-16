<?php
class Periode extends Eloquent {

    public function classrooms()
    {
        return $this->belongsToMany('Classroom');
    }

    public function students()
    {
        return $this->belongsToMany('Student')->withPivot('classroom_id')->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany('Payment');
    }
}