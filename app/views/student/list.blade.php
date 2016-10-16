@extends('tpl')

@section('content')
        <div class="col-lg-12">
            <h1 class="page_title">Elèves</h1>
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

            @if(Session::has('eleve_non_inscrit'))
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4>{{Session::get('eleve_non_inscrit')}}</h4>
                <p><a class="btn btn-primary" href="<?php echo url('student/reinscription/'.Session::get('student_id')); ?>">Affecter cet élève à une session</a></p>
            </div>
            @endif

            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">
                    <div>
                        <a class="btn btn-sm btn-primary" href="{{url('student/add')}}"><i class="icon icon-edit"></i> Inscrire un élève</a>
                        <div class="options btn-group">
                            <a class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> Options</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="imprimer" href="<?php echo url('student/list-to-pdf'); ?>">
                                        <i class="icon-print"></i> Imprimer la liste</a>
                                </li>
                                <hr class="divider">
                                <li>
                                    <a class="imprimer" href="<?php echo url('student/list-to-pdf/save'); ?>">
                                        <i class="icon-save"></i> Enregistrer la liste au format PDF</a>
                                </li>
                            </ul>
                        </div>
                    </div>
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
                                        <div class="col-lg-2">
                                            <?php echo Form::label('periode_id','Session'); ?>
                                            <?php echo Form::select('periode_id',$liste_periode,value(function(){
                                                $session_active = Periode::where('actif','oui')->first();
                                                return $session_active->id;
                                            }),array('class'=>'form-control')); ?>
                                        </div>
                                        <div class="col-lg-2">
                                            <?php echo Form::label('category_id','Catégorie'); ?>
                                            <?php echo Form::select('category_id',$liste_categorie,null,array('class'=>'form-control','lien_ajax'=>url('student/get-liste-classroom'))); ?>
                                        </div>
                                        <div class="col-lg-3" id="classrooms">
                                            <?php echo Form::label('classroom_id','Classe'); ?>
                                            <?php echo Form::select('classroom_id',$liste_classe,null,array('class'=>'form-control','disabled'=>'disabled')); ?>
                                        </div>
                                        <div class="col-lg-4">
                                            <?php echo Form::label('nom','Nom de l\'élève'); ?>
                                            <?php echo Form::text('nom',null,array('class'=>'form-control','placeholder'=>'Nom de l\'élève')); ?>
                                        </div>
                                        <div class="col-lg-1">
                                            <label for="">-</label>
                                            <button type="submit" class="btn btn-small btn-default btn-block">Valider</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div id="contenu_filtre_scolarite" class="well" style="padding: 5px; margin-top: 8px;">
                                                <div class="checkbox">
                                                    <label>
                                                        <?php echo Form::checkbox('filtre_scolarite',1,false,array('id' => 'filtre_scolarite')); ?>
                                                        Elèves non à jour sur la scolarité.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">

                                        </div>
                                        <div class="col-lg-4">
                                        </div>
                                        <div class="col-lg-1">
                                        </div>
                                    </div>
                                <?php echo Form::close(); ?>
                            </div>
                        </div>
                        <br/>

                        <div id="loader"></div>

                        <div id="liste_eleve">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="define_payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Définition des frais de scolarité pour une session</h4>
                        </div>
                        <div class="modal-body" id="content_define_payment">
                            <form id="form_define_payment" action="<?php echo url('student/set-periode-scolarite'); ?>" current_classe_id="" method="post">
                                <input type="hidden" name="back" value="<?php echo Request::fullUrl(); ?>"/>
                                <input type="hidden" name="student_id" value=""/>
                                <div class="form-group" id="payment_periode">

                                </div>
                                <div class="form-group" id="payment_periode_value">
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

            <div class="modal fade" id="supprimer_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Vous êtes sur le point de supprimer un élève</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger">Etes-vous sûr de vouloir supprimer cet élève ?</div>
                            <hr/>
                            <button type="button" class="btn btn-small btn-primary" data-dismiss="modal">Annuler</button>
                            <a href="#" class="btn btn-danger" id="action_supprimer_user">
                                <i class="fa fa-trash-o"></i> Supprimer l'élève</a>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="modal fade" id="desinscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Veuillez choisir une session dans la liste</h4>
                        </div>
                        <div class="modal-body" id="content_add_to_session">
                            <div class="alert alert-danger">
                                <b>Attention !</b> Vous êtes sur le point de supprimer un élève d'une session, cette action est irréversible.
                                Si vous effectuez cette action, toutes les données de l'élève relatives à la session en question seront
                                supprimées notamment les frais de scolarités.
                            </div>

                            <h4>Etes-vous sûr de vouloir supprimer l'élève de cette session ?</h4>
                            <form id="form_desinscription" action="" static_action="" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit" name="confirmer"><i class="icon icon-trash"></i> Désinscrire</button>
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

            <script type="text/javascript">
                $(document).ready(function(){

                    $('body').on('click','.define_payment',function(){
                        $('#payment_periode_value').hide();
                        $('#form_define_payment :input[name="student_id"]').val($(this).attr('id'));
                        var lien_liste_periode = $(this).attr('lien_periode');
                        $.ajax({
                            'url': lien_liste_periode,
                            'type': 'POST',
                            'dataType': 'html',
                            'success': function(data){
                                $('#payment_periode').html(data);
                            }

                        });

                    });

                    $('body').on('change','#payment_periode :input[name="periode_id"]',function(){
                        $('#payment_periode_value').before('<i class="icon icon-spinner icon-spin icon-2x"></i>');
                        var data = $('#form_define_payment').serialize();
                        $.ajax({
                            'url': '<?php echo url('student/get-periode-scolarite'); ?>',
                            'type': 'POST',
                            'dataType': 'html',
                            'data': data,
                            'success': function(data) {
                                if( data != '' ){
                                    $('#form_define_payment i.icon').remove();
                                    $('#payment_periode_value').show();
                                    $('#define_payment_scolarite').val(data);
                                } else {
                                    $('#form_define_payment i.icon').remove();
                                    $('#define_payment_scolarite').val('okoko');
                                    $('#payment_periode_value').hide();
                                }
                            }
                        });
                    });

                    //Enregistrement de la liste au format PDF
                    $('.imprimer').click(function() {
                        window.open($(this).attr('href'));
                        return false;
                    });



                    //Cette section affiche ou non le filtre des eleves non en regle sur la scolarite========================
                    //Car la scolarite depend de la session
                    if( $('#periode_id').val() == 'choix' ) {
                        $('#filtre_scolarite').attr('checked',false);
                        $('#contenu_filtre_scolarite').hide();
                    } else{
                        $('#contenu_filtre_scolarite').fadeIn();
                    }

                    $('#periode_id').change(function(){
                        if( $(this).val() == 'choix' ) {
                            $('#filtre_scolarite').attr('checked',false);
                            $('#contenu_filtre_scolarite').hide();
                        } else{
                            $('#contenu_filtre_scolarite').fadeIn();
                        }
                    });
                    //======================================================================================================

                    function afficherListeEleve(){
                        $('#loader').empty().html('<i class="icon icon-spinner icon-spin icon-2x"></i> Filtre en cours...');
                        var url = $('#recherche').attr('action');
                        var data = $('#recherche').serialize();
                        $.ajax({
                            'url': url,
                            'data': data,
                            'type': 'POST',
                            'dataType': 'html',
                            'success': function(data){
                                $('#loader').empty();
                                $('#liste_eleve').empty().html(data);
                                //alert(data);
                            }
                        });
                    }

                    $('body').on('change','#category_id, #periode_id',function(){
                        $('#classrooms').empty().html('<i class="icon icon-spinner icon-spin icon-2x"></i> Chargement...');
                        var data = $('#recherche').serialize();
                        $.ajax({
                            'url': '<?php echo url('student/get-liste-classroom/choix'); ?>',
                            'type': 'POST',
                            'dataType': 'html',
                            'data': data,
                            'success': function(data){
                                $('#classrooms').empty().html(data);
                            }
                        });
                        return false;
                    });

                    //=======================================================================================================
                    afficherListeEleve();
                    $('body').on('submit','#recherche',function(){
                        afficherListeEleve();
                        return false;
                    });

                    $('body').on('change','#periode_id, #category_id, #classroom_id, #filtre_scolarite',function(){
                        afficherListeEleve();
                        return false;
                    });

                    $('body').on('click','.pagination li a',function(){
                        $('#loader').empty().html('<i class="icon icon-spinner icon-spin icon-2x"></i> Filtre en cours...');
                        var url = $(this).attr('href');
                        var data = $('#recherche').serialize();
                        $.ajax({
                            'url': url,
                            'data': data,
                            'type': 'POST',
                            'dataType': 'html',
                            'success': function(data){
                                $('#loader').empty();
                                $('#liste_eleve').empty().html(data);
                                //alert(data);
                            }
                        });
                        return false;

                    });

                    $('.supprimer_user').click(function(){
                        $('#action_supprimer_user').attr('href',$(this).attr('lien'));
                    });

                    //DESINSCRIPTION DUN ELEVE=======================================================================================
                    $('body').on('click','.desinscription',function(){
                        var url = $(this).attr('lien_periode');
                        var $form = $('#form_desinscription');
                        $form.attr('action',$(this).attr('lien'));
                        $form.attr('static_action',$(this).attr('lien'));
                        $.ajax({
                            'type': 'POST',
                            'dataType': 'html',
                            'url': url,
                            'success':function(data){
                                $form.find('select').remove()
                                    .end().find('.form-group .input-group').append(data);
                            }
                        });
                    });


                    $('body').on('change','#form_desinscription :input[name="periode_id"]',function()
                    {
                        var $form = $('#form_desinscription');
                        var action =  $form.attr('static_action')+'/'+$(this).val();
                        $form.attr('action',action);
                    });

                    //===SUPPRESSION DUN ELEVE===================================================================
                    $('body').on('click','.supprimer_eleve',function(){
                       $('#action_supprimer_user').attr('href',$(this).attr('lien'));
                    });

                });


            </script>

        </div>

@stop