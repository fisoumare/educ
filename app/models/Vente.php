<?php
class Vente extends Eloquent {

    public function produit(){
        return $this->belongsTo('Produit');
    }

    public function scopePanier($query){
        return $query->where('etat',2);
    }

    public function scopeConfirmed($query){
        return $query->where('etat',1);
    }

    public static function montant_panier(){
        $prix = 0;
        foreach(Vente::panier()->get() as $p){
            $prix = $prix + ($p->prix * $p->quantite);
        }

        return $prix;
    }
}