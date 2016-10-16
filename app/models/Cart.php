<?php
class Cart extends Eloquent {

    public function ventes(){
        return $this->hasMany('Vente');
    }

}