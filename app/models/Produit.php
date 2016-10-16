<?php
class Produit extends Eloquent {

    public function ventes(){
        return $this->hasMany('Vente');
    }

    public function scopeActif($query){
        return $query->where('etat',1);
    }

}