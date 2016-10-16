@extends('tpl')

@section('content')

    <div class="col-lg-12">
        <h1 class="page_title">Utilisateurs</h1>
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

        <div class="row">
            <?php if(CurrentUser::is_admin()): ?>
                <div class="col-lg-4">
                    <p>
                        <a href="<?php echo url('user/add'); ?>" class="btn btn-sm btn-primary">Nouvel utilisateur</a>
                    </p>
                </div>
            <?php endif; ?>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel">

                    <div id="zone_recherche" class="row">
                        <div class="col-lg-12">
                            <?php echo Form::open(array('url'=>'user/list','class'=>'form-inline')); ?>
                            <div class="row">
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary btn-small btn-default btn-block">Rechercher</button>
                                </div>
                                <div class="col-lg-10">
                                    <?php echo Form::text('nom',Input::old('nom'),array('class' => 'form-control','placeholder' => 'Nom de l\'utilisateur')); ?>
                                </div>
                            </div>
                            <?php echo Form::close(); ?>
                        </div>
                    </div>

                    <br/>

                    <?php if(count($liste_user) > 0): ?>
                        <table class="table table-responsive table-striped table-hover">
                            <tr style="font-weight: bold;">
                                <td>#</td>
                                <td></td>
                                <td>type</td>
                                <td>Identifiant</td>
                                <td>Nom</td>
                                <td>Prénom</td>
                                <td></td>
                            </tr>
                            <?php $i = 1; foreach($liste_user as $u): ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        <?php if(!empty($u->photo)): ?>
                                            <img style="height: 30px;" src="<?php echo url('assets/img/users/'.$u->photo); ?>" alt="<?php echo $u->nom; ?>"/>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>{{$u->type}}</td>
                                    <td>{{$u->identifiant}}</td>
                                    <td>{{$u->nom}}</td>
                                    <td>{{$u->prenom}}</td>
                                    <td style="min-width: 150px;">
                                        <div class="btn-group pull-right">
                                            <a class="btn btn-default" href="<?php echo url('user/profil/'.$u->id); ?>">
                                                <i class="icon icon-eye-open"></i></a>
                                            <?php if( $u->type != 'Administrateur' ): ?>
                                                <a class="btn btn-success" href="<?php echo url('user/add/'.$u->id); ?>">
                                                    <i class="icon icon-edit"></i></a>
                                                <a data-toggle="modal" href="#supprimer_user" lien="<?php echo url('user/delete/'.$u->id); ?>" class="btn btn-danger supprimer_user">
                                                    <i class="icon icon-trash"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; ?>
                        </table>
                        <?php echo $liste_user->links(); ?>
                    <?php else: ?>
                        <?php if(Input::old()): ?>
                            <div class="alert alert-dismissable alert-info">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Aucun utilisateur ne correspond à ces paramètres de recherche.</strong> {{ link_to('user/list','Réinitialiser la recherche',array('class'=>'btn btn-small btn-default')) }}
                            </div>
                        <?php else: ?>
                            <div class="alert alert-dismissable alert-info">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Aucun utilisateur dans la liste.</strong> {{ link_to('user/add','Ajouter un utilisateur',array('class'=>'btn btn-default')) }}
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="supprimer_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Vous êtes sur le point de supprimer un utilisateur</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">Etes-vous sûr de vouloir supprimer cet utilisateur ?</div>
                        <hr/>
                        <button type="button" class="btn btn-small btn-primary" data-dismiss="modal">Annuler</button>
                        <a href="#" class="btn btn-danger" id="action_supprimer_user">
                            <i class="fa fa-trash-o"></i> Supprimer l'utilisateur</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script type="text/javascript">
            $(document).ready(function(){
                $('.supprimer_user').click(function(){
                    $('#action_supprimer_user').attr('href',$(this).attr('lien'));
                });
            });
        </script>
    </div>

@stop