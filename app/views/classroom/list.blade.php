@extends('tpl')

@section('content')
        <div class="col-lg-12">
            <h1 class="page_title">Classes</h1>
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

            @if(Session::has('plus_dune_session'))
            <div class="alert alert-dismissable alert-info">
                <strong>Attention ! Une classe ne peut exister sans appartenir à une session.
                    La classe "<?php echo Session::get('classe'); ?>" n'est liée qu'à une seule session. Si vous
                la supprimez de la session "<?php echo Session::get('periode'); ?>", elle sera définitivement supprimée. <br/>
                Etes-vous sûr de vouloir suppimer la classe de cette session ? <br/>
               <p>
                   <a class="btn btn-xs btn-default" href="<?php echo url('classroom/list'); ?>">Annuler</a>
                   <a class="btn btn-xs btn-danger" href="<?php echo url(Session::get('lien'));  ?>">Supprimer</a>
               </p>
                </strong>
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
                        <a class="btn btn-sm btn-primary" href="{{url('classroom/add')}}"><i class="icon icon-edit"></i> Ajouter une classe</a>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">

                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo Form::open(array('url'=>Request::path(),'class'=>'form-inline','id'=>'recherche')); ?>
                                {{ Form::token() }}
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?php echo Form::label('periode_id','Session'); ?>
                                        <?php echo Form::select('periode_id',$liste_periode,
                                            (Session::has('recherche_classe.periode'))?Session::get('recherche_classe.periode'):Periode::where('actif','oui')->first()->id,
                                        array('class'=>'form-control')); ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <?php echo Form::label('category_id','Catégorie'); ?>
                                        <?php echo Form::select('category_id',$liste_categorie,
                                            (Session::has('recherche_classe.category'))?Session::get('recherche_classe.category'):null,
                                            array('class'=>'form-control','lien_ajax'=>url('student/get-liste-classroom'))); ?>
                                    </div>
                                    <div class="col-lg-5">
                                        <?php echo Form::label('nom','Nom de la classe'); ?>
                                        <?php echo Form::text('nom',
                                            (Session::has('recherche_classe.nom'))?Session::get('recherche_classe.nom'):Input::old('nom'),
                                            array('class' => 'form-control', 'placeholder'=>'Nom de la classe')); ?>
                                    </div>
                                    <div class="col-lg-1">
                                        <label for="">-</label>
                                        <button type="submit" class="btn btn-small btn-default btn-block">Valider</button>
                                    </div>
                                </div>
                                <?php echo Form::close(); ?>
                            </div>
                        </div>

                        <?php if( Session::has('recherche_classe') ): ?>
                            <div class="alert alert-info" style="margin-top: 10px;">
                                Résultat de la recherche. <a class="btn btn-xs btn-success" href="<?php echo url('classroom/list/init'); ?>">Réinitiliser la recherche</a>
                            </div>
                        <?php endif; ?>

                        <br/>

                        <?php if(count($liste_classe) > 0): ?>
                            <table class="table table-responsive table-striped table-hover table-condensed">
                                <tr style="font-weight: bold;">
                                    <td>#</td>
                                    <td>Nom</td>
                                    <td>Catégorie</td>
                                    <td>Nbre élèves</td>
                                    <td>Frais de scolarité</td>
                                    <td></td>
                                </tr>
                                <?php $i = 1; foreach($liste_classe as $classe): ?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$classe->nom}}</td>
                                        <td>{{$classe->category->nom}}</td>
                                        <td>{{$classe->students->count()}}</td>
                                        <td>
                                            <?php
                                                $scolarite = DB::table('classroom_periode')
                                                ->where('classroom_id','=',$classe->id)
                                                ->where('periode_id','=',$current_periode_id)->pluck('scolarite');
                                                if( !empty($scolarite) ){
                                                    echo $scolarite.' '.Ets::get('devise');
                                                } else{
                                                    echo Periode::find($current_periode_id)->scolarite.' '.Ets::get('devise');
                                                }
                                            ?>
                                        </td>
                                        <td style="min-width: 150px;">
                                            <div class="options btn-group pull-right">
                                                <a class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> Options</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="<?php echo url('classroom/add/'.$classe->id); ?>">
                                                            <i class="icon-pencil"></i> Editer</a>
                                                    </li>
                                                    <hr class="divider">
                                                    <li>
                                                        <a id="{{$classe->id}}" class="define_payment" data-toggle="modal" href="#define_payment" lien="<?php echo url('classroom/define-payment/'.$classe->id); ?>" lien_periode="<?php echo url('classroom/set-periode-scolarite/'.$classe->id); ?>" >
                                                            <i class="icon-money"></i> Définir la scolarité</a>
                                                    </li>
                                                    <hr class="divider">
                                                    <li>
                                                        <a class="add_to_periode" data-toggle="modal" href="#add_to_periode" lien_add="<?php echo url('classroom/add-to-periode/'.$classe->id); ?>" lien_get_periode="<?php echo url('classroom/get-liste-periode-to-add/'.$classe->id); ?>">
                                                            <i class="icon-link"></i> Lier à une session</a>
                                                    </li>
                                                    <li>
                                                        <a class="remove_to_periode" data-toggle="modal" href="#remove_to_periode" lien="<?php echo url('classroom/remove-to-periode/'.$classe->id); ?>" lien_periode="{{url('classroom/get-liste-periode/'.$classe->id)}}">
                                                            <i class="icon-unlock"></i> Retirer d'une session</a>
                                                    </li>
                                                    <hr class="divider">
                                                    <li>
                                                        <a class="supprimer" data-toggle="modal" href="#delete" lien="<?php echo url('classroom/delete/'.$classe->id); ?>" >
                                                            <i class="icon-trash"></i> Supprimer</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; endforeach; ?>
                            </table>
                            <?php echo $liste_classe->links(); ?>
                        <?php else: ?>
                            <?php if(Input::old()): ?>
                                <div class="alert alert-dismissable alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Aucun utilisateur ne correspond à ces paramètres de recherche.</strong> {{ link_to('user/list','Réinitialiser la recherche',array('class'=>'btn btn-small btn-default')) }}
                                </div>
                            <?php else: ?>
                                <div class="alert alert-dismissable alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Aucune classe dans la liste.</strong>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

            <div class="modal fade" id="define_payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Définition des frais de scolarité pour une session</h4>
                        </div>
                        <div class="modal-body" id="content_define_payment">
                            <form id="form_define_payment" action="" current_classe_id="" method="post">
                                <input type="hidden" name="back" value="<?php echo Request::fullUrl(); ?>"/>
                                <div class="form-group">
                                    <select name="define_payment_periode_id" id="define_payment_periode_id" class="form-control">
                                        <option value="choix">Veuillez choisir une session dans la liste</option>
                                        <?php foreach( Periode::orderBy('id','desc')->get() as $p ): ?>
                                            <option value="{{$p->id}}" scolarite="{{$p->scolarite}}">
                                                {{$p->interval}}
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input id="define_payment_scolarite" type="text" name="define_payment_scolarite" class="form-control" placeholder="Entrer le montant" />
                                        <span class="input-group-addon"> {{Ets::get('devise')}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-sm btn-primary" type="submit" name="enregistrer">
                                        <i class="icon icon-save"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


            <div class="modal fade" id="add_to_periode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Veuillez choisir les sessions</h4>
                        </div>
                        <div class="modal-body" id="content_add_to_session">
                            <form id="form_add_to_periode" action="" method="post">
                                <input type="hidden" name="back" value="<?php echo Request::fullUrl(); ?>"/>
                                <div class="form-group" id="liste_periode_to_add">

                                </div>
                                <hr/>
                                <input class="btn btn-primary" type="submit" name="valider" value="Valider">
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="modal fade" id="remove_to_periode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Veuillez choisir une session dans la liste</h4>
                        </div>
                        <div class="modal-body" id="content_add_to_session">
                            <div class="alert alert-danger">
                                <b>Attention !</b> Vous êtes sur le point de supprimer une classe d'une session, cette action est irréversible.
                                Si vous effectuez cette action, toutes les données des élèves relatives à la classe ainsi que la session seront
                                supprimées notamment les frais de scolarités.
                            </div>

                            <h4>Etes-vous sûr de vouloir supprimer la classe de cette session ?</h4>
                            <form id="form_remove_to_periode" action="" static_action="" method="post">
                                <div class="form-group">
                                    <input type="hidden" name="back" value="<?php echo Request::fullUrl(); ?>"/>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit" name="confirmer"><i class="icon icon-trash"></i> Supprimer</button>
                                        </span>
                                        <select name="periode_to_remove_id" id="periode_to_remove_id" class="form-control">
                                            <option value="choix">Veuillez choisir une session dans la liste</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Vous êtes sur le point de supprimer une salle de classe</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger">
                                <b>Attention !</b> Vous êtes sur le point de supprimer une salle de classe. Cette action est irréversible.
                                Si vous effectuez cette action, toutes les données des élèves relatives à la classe ainsi que toutes les session seront
                                supprimées.
                                <hr/>
                            <strong>Etes-vous sûr de vouloir supprimer cette salle de classe ?</strong></div>
                            <hr/>
                            <button type="button" class="btn btn-small btn-primary" data-dismiss="modal">Annuler</button>
                            <a href="#" class="btn btn-danger" id="action_supprimer">
                                <i class="fa fa-trash-o"></i> Supprimer</a>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <script type="text/javascript">
                $(document).ready(function(){

                    $('body').on('click','.define_payment',function(){
                       $('#form_define_payment').attr('action',$(this).attr('lien_periode'));
                       $('#form_define_payment').attr('current_classe_id',$(this).attr('id'));

                    });

                    $('body').on('change','#define_payment_periode_id',function(){
                        $.ajax({
                            'type': 'POST',
                            'dataType': 'html',
                            'data': {periode_id:$(this).val(),classroom_id:$('#form_define_payment').attr('current_classe_id')},
                            'url': '<?php echo url('classroom/get-periode-scolarite'); ?>',
                            'success':function(data){
                                $('#define_payment_scolarite').val(data);
                            }
                        });

                    });

                    //LIAISON DUNE CLASSE A UNE SESSIONE=======================================================================================
                    $('body').on('click','.add_to_periode',function(){
                        $('#liste_periode_to_add').empty();
                        var url_add = $(this).attr('lien_add');
                        var url_get_periode = $(this).attr('lien_get_periode');
                        $('#form_add_to_periode').attr('action',url_add);
                        $.ajax({
                            'type': 'POST',
                            'dataType': 'html',
                            'url': url_get_periode,
                            'success':function(data){
                                $('#liste_periode_to_add').html(data);
                            }
                        });
                    });


                    //SUPPRESSION DUNE CLASSE DUNE SESSIONE=======================================================================================
                    $('body').on('click','.remove_to_periode',function(){
                        var url = $(this).attr('lien_periode');
                        var $form = $('#form_remove_to_periode');
                        $form.find('select').remove();
                        $form.attr('action',$(this).attr('lien'));
                        $form.attr('static_action',$(this).attr('lien'));
                        $.ajax({
                            'type': 'POST',
                            'dataType': 'html',
                            'url': url,
                            'success':function(data){
                                $form.find('.form-group .input-group').append(data);
                            }
                        });
                    });


                    $('body').on('change','#form_remove_to_periode :input[name="periode_id"]',function()
                    {
                        var $form = $('#form_remove_to_periode');
                        var action =  $form.attr('static_action')+'/'+$(this).val();
                        $form.attr('action',action);
                    });

                    //SUPPRIMER UNE CLASSE =======================================================================================
                    $('.supprimer').click(function(){
                        $('#action_supprimer').attr('href',$(this).attr('lien'));
                    });
                });
            </script>

        </div>

@stop