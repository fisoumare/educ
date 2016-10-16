@extends('tpl')

@section('content')

    <h1>Liste des produits</h1>

    @include('produit.menu')
    @include('produit.search')

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

    <?php if(Input::old()): ?>
        <div class="alert alert-dismissable alert-info">
            <p>{{ link_to('produit/list','Réinitialiser la recherche',array('class'=>'btn btn-small btn-default')) }}</p>
        </div>
    <?php endif; ?>

    <?php if(count($liste_produit) > 0): ?>
        <table class="table table-responsive table-hover">
            <tr style="font-weight: bold;">
                <td>#</td>
                <td></td>
                <td>Réf</td>
                <td>Nom</td>
                <td>Prix</td>
                <td>Quantité</td>
                <td>Date d'expiration</td>
                <td></td>
            </tr>
        <?php $i = 1; foreach($liste_produit as $p): ?>

            <?php if( $p->expiration != null AND $p->expiration != '0000-00-00' ):
                $date_restante_avant_expiration = FormatDate::timestamp($p->expiration) - FormatDate::timestamp(date('Y-m-d'));
                $timestamp_de_trois_mois = 90*24*60*60;
                if( $date_restante_avant_expiration < $timestamp_de_trois_mois ):
                    $p->expire_bientot = true;
                endif;
            endif; ?>

            <tr class="<?php if( $p->expire_bientot == true){ echo 'alert alert-danger';} ?>" >
                <td>{{$i}}</td>
                <td>
                    <?php if(!empty($p->photo)): ?>
                        <img style="height: 30px;" src="<?php echo url('assets/img/produits/'.$p->photo); ?>" alt="<?php echo $p->nom; ?>"/>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>{{$p->ref}}</td>
                <td>{{$p->nom}}</td>
                <td>{{$p->prix}}</td>
                <td>{{$p->stock}}</td>
                <td>
                    <?php if( $p->expiration != null AND $p->expiration != '0000-00-00' ): ?>
                        <p><?php echo FormatDate::barres($p->expiration); ?></p>
                        <?php
                        $date_restante_avant_expiration = FormatDate::timestamp($p->expiration) - FormatDate::timestamp(date('Y-m-d'));
                        $timestamp_de_trois_mois = 90*24*60*60;
                        if( $date_restante_avant_expiration < $timestamp_de_trois_mois ): ?>
                            <p>Ce produit expire dans moins de 3 mois.</p>
                        <?php endif; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td style="min-width: 150px;">
                    <div class="btn-group pull-right">

                        <a class="btn btn-default" href="<?php echo url('produit/view/'.$p->id); ?>">
                            <i class="fa fa-eye"></i></a>
                        <?php if(CurrentUser::is_admin()): ?>
                        <a class="btn btn-default add_stock" data-toggle="modal" href="#add_stock" id="<?php echo $p->id; ?>">
                            <i class="fa fa-plus-square"></i></a>
                        <a class="btn btn-success" href="<?php echo url('produit/add/'.$p->id); ?>">
                            <i class="fa fa-edit"></i></a>
                        <a data-toggle="modal" href="#supprimer_produit" lien="<?php echo url('produit/delete/'.$p->id); ?>" class="btn btn-danger supprimer_produit">
                            <i class="fa fa-trash-o"></i></a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php $i++; endforeach; ?>
        </table>
        <?php echo $liste_produit->links(); ?>
    <?php else: ?>
        <?php if(Input::old()): ?>
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Aucun produit ne correspond à ces paramètres de recherche dans votre stock.</strong> {{ link_to('produit/list','Réinitialiser la recherche',array('class'=>'btn btn-small btn-default')) }}
            </div>
        <?php else: ?>
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Aucun produit dans la liste.</strong> {{ link_to('produit/add','Ajouter un produit',array('class'=>'btn btn-default')) }}
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="modal fade" id="add_stock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Ajouter au stock</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url'=>'produit/add-stock')) }}
                    {{ Form::token() }}
                    <?php echo Form::label('quantite','Veuillez choisir la quantité à ajouter'); ?>
                    <?php echo Form::text('quantite',Input::old('quantite'),array('class'=>'form-control')); ?>
                    <input type="hidden" name="produit_id" id="produit_id" value=""/>
                    <hr/>
                    <button type="button" class="btn btn-small btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus-square"></i> Ajouter</button>
                    {{ Form::close() }}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="supprimer_produit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Vous êtes sur le point de supprimer un produit</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">Etes-vous sûr de vouloir supprimer ce produit de votre stock ?</div>
                    <hr/>
                    <button type="button" class="btn btn-small btn-primary" data-dismiss="modal">Annuler</button>
                    <a href="#" class="btn btn-danger" id="action_supprimer_produit">
                        <i class="fa fa-trash-o"></i> Supprimer le produit</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('.supprimer_produit').click(function(){
                $('#action_supprimer_produit').attr('href',$(this).attr('lien'));
            });

            $('.add_stock').click(function(){
                $('#produit_id').attr('value',$(this).attr('id'));
            });
        });
    </script>

@stop