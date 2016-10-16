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

    @include('vente.menu')

    {{ Form::open(array('url'=>'vente/search')) }}
    {{ Form::token() }}

    <div class="row">
        <div class="col-lg-7">
            <div class="panel panel-primary" style="min-height: 400px;">
                <div class="panel-heading">
                    Entrer le code barre du produit à vendre
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <?php echo Form::text('ref',Input::old('ref'),array('class' => 'form-control','placeholder' => 'Code barre du produit à vendre')); ?>
                        </div>
                        <div class="col-lg-3">
                            <?php echo Form::submit('Rechercher',array('class'=>'btn btn-primary btn-block')); ?>
                        </div>
                    </div>

                    <?php if( isset($produit) ): ?>
                    <hr>
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
                                    <td><b>Nom</b></td>
                                    <td>{{ $produit->nom }}</td>
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
        <div class="col-lg-5">
            <div class="panel panel-warning" style="min-height: 400px;">
                <div class="panel-heading">
                    Panier
                </div>
                <div class="panel-body">
                    <?php //var_dump($panier->get()->first()); ?>
                    <?php if( $panier->first() != null ): ?>
                        <table class="table table-condensed table-striped">
                            <tr style="font-weight: bold">
                                <td>Nom</td>
                                <td>Qté</td>
                                <td>Prix</td>
                                <td>Remise</td>
                            </tr>
                            <?php foreach($panier as $p): ?>
                            <tr>
                                <td>{{ $p->produit->nom }}</td>
                                <td>{{ $p->quantite }}</td>
                                <td>{{ $p->prix }} {{Ets::get('devise')}}</td>
                                <td>{{ $p->remise }} %</td>
                            </tr>
                            <?php endforeach; ?>
                            <tr class="alert alert-success">
                                <td>Montant du panier</td>
                                <td colspan="3"><b>{{ Vente::montant_panier() }} {{Ets::get('devise')}}</b></td>
                            </tr>
                        </table>

                        <p><a data-toggle="modal" href="#vendre_panier" class="btn btn-primary btn-block">Vendre le panier</a></p>
                        <p><a data-toggle="modal" href="#supprimer_panier" class="btn btn-danger btn-block">Supprimer le contenu</a></p>
                    <?php else: ?>
                        <p>Aucun produit.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

        <div class="modal fade" id="vendre_panier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Vous êtes sur le point de vendre le contenu d panier</h4>
                    </div>
                    <div class="modal-body">
                        <h4>A quel client souhaitez vous vendre le panier</h4>
                        {{ Form::open(array('url'=>'vente/vendre-panier')) }}
                        {{ Form::token() }}
                        <?php echo Form::select('client_panier',$liste_client,'',array('class'=>'form-control')); ?><br/>
                        <button type="button" class="btn btn-small btn-danger" data-dismiss="modal">Annuler</button>
                        <button type="submit" name="action_vendre" value="vendre_panier" class="btn btn-small btn-primary">Confirmer</button>
                        {{ Form::close() }}
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="supprimer_panier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Vous êtes sur le point de suuprimer le contenu d panier</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Etes-vous sûr de vouloir effacer le contenu ?</h4>
                        <hr/>
                        {{ Form::open(array('url'=>'vente/supprimer-panier')) }}
                        {{ Form::token() }}
                        <button type="button" class="btn btn-small btn-danger" data-dismiss="modal">Annuler</button>
                        <button type="submit" name="action_vendre" value="supprimer_panier" class="btn btn-small btn-primary">Confirmer</button>
                        {{ Form::close() }}
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

@stop