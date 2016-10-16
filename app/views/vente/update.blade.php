@extends('tpl')

@section('content')


    <h1>{{$titre_page}}</h1>

    @if(Session::has('liste_erreurs'))
    <div class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Attention ! </strong> {{current(Session::get('liste_erreurs')->all())}}
    </div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}.
    </div>
    @endif

    @if( isset($success) )
    <div class="alert alert-success">
        {{ $success }}.
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

    @if(isset($produit))
    <hr style="border: dotted 1px #ccc; margin-top: 5px; margin-bottom: 5px;">
    <div class="row">
        <div class="col-lg-12">
            {{ Form::open(array('url'=>'vente/update/'.$vente->id)) }}
            {{ Form::token() }}
            <input type="hidden" name="produit_id" value="{{$produit->id}}">
            <div class="row">
                <div class="col-lg-2">
                    <?php echo Form::text('quantite',Input::old('quantite',$vente->quantite),array('class'=>'form-control','placeholder'=>'Quantité')); ?>
                </div>
                <div class="col-lg-3">
                    <div class="form-group input-group">
                        <?php echo Form::text('prix',Input::old('prix',$vente->prix),array('class'=>'form-control','placeholder'=>'Prix de vente')); ?>
                        <span class="input-group-addon"> {{Ets::get('devise')}}</span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group input-group">
                        <?php echo Form::text('remise',Input::old('remise',$vente->remise),array('class'=>'form-control','placeholder'=>'Remise')); ?>
                        <span class="input-group-addon"> %</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php echo Form::select('client',$liste_client,$vente->client_id,array('class'=>'form-control')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <button type="submit" name="modifer_vente" value="confirmer" class="btn btn-small btn-primary">
                        <i class="fa fa-edit"></i> Modifier cette vente
                    </button>
                    <a href="{{ url('vente/view') }}" class="btn btn-default">Revenir à l'historique</a>
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
    <hr style="border: dotted 1px #ccc; margin-top: 5px; margin-bottom: 5px;">
    @endif


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary" style="min-height: 400px;">
                <div class="panel-heading">
                    Attributs du produit
                </div>
                <div class="panel-body">
                    <?php if( isset($produit) ): ?>
                    <h3>{{ $produit->nom }}</h3>
                    <div class="row">
                        <?php if( !empty($produit->photo)): ?>
                        <div class="col-lg-2">
                            <img class="img-thumbnail img-responsive" src="<?php echo url('assets/img/produits/'.$produit->photo); ?>" alt="{{ $produit->nom }}"/>
                        </div>
                        <div class="col-lg-10">
                        <?php else: ?>
                        <div class="col-lg-12">
                        <?php endif; ?>
                            <table class="table">
                                <tr>
                                    <td><b><span style="font-size: 18px" class="label label-info">{{ $produit->prix }} {{Ets::get('devise')}}</span></b></td>
                                    <td></td>
                                </tr>
                                <tr class="right">
                                    <td><b>Référence</b></td>
                                    <td>{{ $produit->ref }}</td>
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
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

        <div class="modal fade" id="supprimer_panier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Vous êtes sur le point de modifier une vente déja effectuée</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Etes-vous sûr de vouloir modifier cette vente ?</h4>
                        <hr/>
                        {{ Form::open(array('url'=>'vente/update')) }}
                        {{ Form::token() }}
                        <button type="button" class="btn btn-small btn-danger" data-dismiss="modal">Annuler</button>
                        <button type="submit" name="action_vendre" value="supprimer_panier" class="btn btn-small btn-primary">Confirmer</button>
                        {{ Form::close() }}
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

@stop