@extends('tpl')

@section('content')

    <h1>Fiche du produit</h1>

    @include('produit.menu')

    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}. <a class="btn btn-sm btn-success" href="<?php echo url('produit/view/'.Session::get('id')); ?>">Voir la fiche du produit</a>
    </div>
    @endif

    @if(Session::has('info'))
    <div class="alert alert-dismissable alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{Session::get('info')}}
    </div>
    @endif

    @if(Session::has('error'))
    <div class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{Session::get('error')}}
    </div>
    @endif

    <?php if( $produit != null ): ?>
        
        <p>
            <a class="btn btn-sm btn-info" href="{{ url('produit/add/'.$produit->id) }}">
                <i class="fa fa-edit"></i> Modifier le produit
            </a>
        </p>
        
        <div class="row">
            <div class="col-lg-8">
                <table class="table">
                    <tr class="right">
                        <td><b>Référence</b></td>
                        <td>{{ $produit->ref }}</td>
                    </tr>
                    <tr>
                        <td><b>Nom</b></td>
                        <td>{{ $produit->nom }}</td>
                    </tr>
                    <tr>
                        <td><b>Prix</b></td>
                        <td><span class="label label-info">{{ $produit->prix }} {{Ets::get('devise')}}</span></td>
                    </tr>
                    <tr>
                        <td><b>Quantité en stock</b></td>
                        <td>{{ $produit->stock }}</td>
                    </tr>
                    <tr>
                        <td><b>Seuil d'alert de stock</b></td>
                        <td>{{ $produit->seui_alert_stock }}</td>
                    </tr>
                    <tr>
                        <td><b>Date d'ajout</b></td>
                        <td>{{ $produit->updated_at }}</td>
                    </tr>
                    <tr>
                        <td><b>Dernière motification</b></td>
                        <td>{{ $produit->created_at }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-4">
                <img class="img-responsive img-thumbnail" src="<?php echo asset('assets/img/produits/'.$produit->photo); ?>" alt="<?php echo $produit->nom; ?>"/>
            </div>
        </div>
    <?php endif; ?>
@stop