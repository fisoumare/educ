@extends('tpl')

@section('content')
        <div class="col-lg-12">

            <h1 class="page_title">Sessions</h1>

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

            <?php echo Form::open(array('url'=>Request::path())); ?>
            {{ Form::token() }}
            <div class="row">
                <div class="col-lg-12">
                    <p>
                        <a class="btn btn-sm btn-primary" href="{{url('periode/add')}}"><i class="icon icon-edit"></i> Nouvelle Session</a>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <?php if(count($liste_periode) > 0): ?>
                            <table class="table table-responsive table-striped table-hover table-condensed">
                                <tr style="font-weight: bold;">
                                    <td></td>
                                    <td>Nom</td>
                                    <td>Période</td>
                                    <td>Date de Début</td>
                                    <td>Nbre de classes</td>
                                    <td>Nbre d'élèves</td>
                                    <td></td>
                                </tr>
                                <?php foreach($liste_periode as $periode): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo url('periode/make-current-session/'.$periode->id); ?>">
                                                @if($periode->actif == 'oui')
                                                <i class="icon icon-star"></i>
                                                @else
                                                <i class="icon icon-star-empty"></i>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            @if( !empty($periode->nom) )
                                                {{$periode->nom}}
                                            @else
                                                Session {{$periode->interval}}
                                            @endif
                                        </td>
                                        <td>{{$periode->interval}}</td>
                                        <td>{{$periode->debut}}</td>
                                        <td><?php echo $periode->classrooms()->count(); ?></td>
                                        <td><?php echo $periode->students()->count(); ?></td>
                                        <td style="min-width: 150px;">
                                            <div class="options btn-group pull-right">
                                                <a class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> Options</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="<?php echo url('periode/add/'.$periode->id); ?>">
                                                            <i class="icon-pencil"></i> Editer</a>
                                                    </li>
                                                    <hr class="divider">
                                                    <li>
                                                        <a href="<?php echo url('periode/make-current-session/'.$periode->id); ?>">
                                                            <i class="icon-money"></i> Définir comme session par défaut</a>
                                                    </li>
                                                    <hr class="divider">
                                                    <li>
                                                        <a class="supprimer" data-toggle="modal" href="#supprimer" lien="<?php echo url('periode/delete/'.$periode->id); ?>" >
                                                            <i class="icon-trash"></i> Supprimer</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                            </table>
                            <?php echo $liste_periode->links(); ?>
                        <?php else: ?>
                            <?php if(Input::old()): ?>
                                <div class="alert alert-dismissable alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Aucune Session ne correspond à ces paramètres de recherche.</strong> {{ link_to('periode/list','Réinitialiser la recherche',array('class'=>'btn btn-small btn-default')) }}
                                </div>
                            <?php else: ?>
                                <div class="alert alert-dismissable alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Aucune Session n'existe pour votre Etablissement.</strong> {{ link_to('periode/add','Créer une Session',array('class'=>'btn btn-sm btn-default')) }}
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

            <div class="modal fade" id="supprimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Vous êtes sur le point de supprimer une Session</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger">
                                <b>Attention !</b> Vous êtes sur le point de supprimer une session, cette action est irréversible.
                                Si vous effectuez cette action, toutes les données des classes, élèves et frais de scolarités relatives à la session seront supprimées.
                            </div>

                            <h4>Etes-vous sûr de vouloir supprimer la classe de cette session ?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <a id="action_supprimer" href="" class="btn btn-primary">Confirmer</a>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <script type="text/javascript">
                $(document).ready(function(){
                    $('.supprimer').click(function(){
                        $('#action_supprimer').attr('href',$(this).attr('lien'));
                    });
                });
            </script>

        </div>

@stop