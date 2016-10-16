@extends('tpl')

@section('content')


    <h1>Historique des ventes</h1>

    @if( Session::has('liste_erreurs') )
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

    @include('vente.menu_historique')

    <?php if(count($historique) > 0): ?>
        <table class="table table-responsive table-hover">
            <tr style="font-weight: bold;">
                <td>#</td>
                <td></td>
                <td>Réf</td>
                <td>Nom</td>
                <td>Prix produit ({{Ets::get('devise')}})</td>
                <td>Remise (%)</td>
                <td>Quantité</td>
                <td>Prix de vente ({{Ets::get('devise')}})</td>
                <td>Total ({{Ets::get('devise')}})</td>
                <td>Date</td>
                <td></td>
            </tr>
            <?php $i = 1; foreach($historique as $h): ?>
                <tr <?php if(Cloture::isClotured($h->created_at)){echo 'class="alert alert-success"';} ?> >
                    <td>{{$i}}</td>
                    <td>
                        <?php if(!empty($h->produit->photo)): ?>
                            <img style="height: 30px;" src="<?php //echo url('assets/img/produits/'.$h->produit->photo); ?>" alt="<?php //echo $h->produit->nom; ?>"/>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>{{$h->produit->ref}}</td>
                    <td>{{$h->produit->nom}}</td>
                    <td>{{$h->produit->prix}}</td>
                    <td>{{$h->remise}}</td>
                    <td>{{$h->quantite}}</td>
                    <td>{{$h->prix}}</td>
                    <td style="font-weight: bold;">{{$h->prix_total}}</td>
                    <td><?php echo FormatDate::lettres($h->created_at,true); ?></td>

                    <td style="min-width: 150px; text-align: right;">
                        <?php if( !Cloture::isClotured($h->created_at) ): ?>
                                <div class="btn-group pull-right">
                                    <a class="btn btn-success" href="<?php echo url('vente/update/'.$h->id); ?>">
                                        <i class="fa fa-edit"></i></a>
                                    <a data-toggle="modal" href="#supprimer_vente" lien="<?php echo url('vente/delete/'.$h->id); ?>" class="btn btn-danger supprimer_vente">
                                        <i class="fa fa-trash-o"></i></a>
                                </div>
                        <?php else: ?>
                            <i class="fa fa-check"></i> Vente clôturée
                        <?php endif; ?>
                    </td>
                </tr>
                <?php $i++; endforeach; ?>
        </table>
        <?php echo $historique->links(); ?>
    <?php else: ?>
        <?php if(Input::old()): ?>
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Aucun produit ne correspond à ces paramètres de recherche dans votre stock.</strong> {{ link_to('produit/list','Réinitialiser la recherche',array('class'=>'btn btn-small btn-default')) }}
            </div>
        <?php else: ?>
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Aucun vente correspondant à cette vente</strong>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if( CurrentUser::is_admin() ): ?>
    <div class="modal fade" id="cloture_jour" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Vous êtes sur le point de clôturer le jour</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">Etes-vous sûr de vouloir clôturer le
                        <?php echo FormatDate::lettres(Session::get('histo_search.isday')); ?> ?</div>
                    <hr/>
                    {{Form::open(array('url'=>'vente/cloture-jour'))}}
                    {{Form::token()}}
                    <input type="hidden" name="date" value="<?php echo Session::get('histo_search.isday'); ?>">
                    <button type="button" class="btn btn-small btn-danger" data-dismiss="modal">Annuler</button>
                    <button type="submit" name="valider" class="btn btn-warning">
                        <i class="fa fa-check"></i> Clôturer le jour</button>
                    {{ Form::close() }}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <?php endif; ?>

    <div class="modal fade" id="supprimer_vente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Vous êtes sur le point de supprimer une vente déja effectuée</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">Etes-vous sûr de vouloir supprimer cette vente ?</div>
                    <hr/>
                    <button type="button" class="btn btn-small btn-primary" data-dismiss="modal">Annuler</button>
                    <a href="#" class="btn btn-danger" id="action_supprimer_vente">
                        <i class="fa fa-trash-o"></i> Supprimer la vente</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('.supprimer_vente').click(function(){
                $('#action_supprimer_vente').attr('href',$(this).attr('lien'));
            });
        });
    </script>

@stop