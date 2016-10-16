<?php
class Client extends Eloquent {

    public function scopeActif($query)
    {
        return $query->where('etat',1);
    }

}