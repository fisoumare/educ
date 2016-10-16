<?php
class User extends Eloquent {

    public function scopeActif($query)
    {
        return $query->where('etat',1);
    }
}