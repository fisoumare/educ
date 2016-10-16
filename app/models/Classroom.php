<?php
class Classroom extends Eloquent {

    public function students()
    {
        return $this->belongsToMany('Student')->withPivot('periode_id');
    }

    public function periodes()
    {
        return $this->belongsToMany('Periode');
    }

    public function category()
    {
        return $this->belongsTo('Category');
    }
}