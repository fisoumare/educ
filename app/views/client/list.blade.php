@extends('tpl')

@section('content')

    <h1>Clients</h1>

    @include('client.menu')
    @include('client.search')

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

    <?php if(count($liste_client) > 0): ?>
        <table class="table table-responsive table-striped table-hover">
            <tr style="font-weight: bold;">
                <td>#</td>
                <td></td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Adresse</td>
                <td>Téléphone</td>
                <td>E-mail</td>
                <td></td>
            </tr>
        <?php $i = 1; foreach($liste_client as $c): ?>
            <tr>
                <td>{{$i}}</td>
                <td>
                    <?php if(!empty($c->photo)): ?>
                        <img style="height: 30px;" src="<?php echo url('assets/img/clients/'.$c->photo); ?>" alt="<?php echo $c->nom; ?>"/>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>{{$c->nom}}</td>
                <td>{{$c->prenom}}</td>
                <td>{{$c->adresse}}</td>
                <td>{{$c->tel}}</td>
                <td>{{$c->email}}</td>
                <td style="min-width: 150px;">
                    <div class="btn-group pull-right">
                        <a class="btn btn-default" href="<?php echo url('client/view/'.$c->id); ?>">
                            <i class="fa fa-eye"></i></a>
                        <a class="btn btn-success" href="<?php echo url('client/add/'.$c->id); ?>">
                            <i class="fa fa-edit"></i></a>
                        <a data-toggle="modal" href="#supprimer_client" lien="<?php echo url('client/delete/'.$c->id); ?>" class="btn btn-danger supprimer_client">
                            <i class="fa fa-trash-o"></i></a>
                    </div>
                </td>
            </tr>
        <?php $i++; endforeach; ?>
        </table>
        <?php echo $liste_client->links(); ?>
    <?php else: ?>
        <?php if(Input::old()): ?>
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Aucun client ne correspond à ces paramètres de recherche.</strong> {{ link_to('client/list','Réinitialiser la recherche',array('class'=>'btn btn-small btn-default')) }}
            </div>
        <?php else: ?>
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Aucun client dans la liste.</strong> {{ link_to('client/add','Ajouter un client',array('class'=>'btn btn-default')) }}
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="modal fade" id="supprimer_client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Vous êtes sur le point de supprimer un client</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">Etes-vous sûr de vouloir supprimer ce client ?</div>
                    <hr/>
                    <button type="button" class="btn btn-small btn-primary" data-dismiss="modal">Annuler</button>
                    <a href="#" class="btn btn-danger" id="action_supprimer_client">
                        <i class="fa fa-trash-o"></i> Supprimer le client</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('.supprimer_client').click(function(){
                $('#action_supprimer_client').attr('href',$(this).attr('lien'));
            });
        });
    </script>
@stop