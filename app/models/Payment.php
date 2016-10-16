<?php
class Payment extends Eloquent {

    public function student()
    {
        return $this->belongsTo('Student');
    }

    public function periode()
    {
        return $this->belongsTo('Periode');
    }
}