@extends('tpl')

@section('content')

        <div class="col-lg-12">
            <h1 class="page_title">{{$page_title}}</h1>
            <div id="alert">
            </div>

            <?php echo Form::open(array('url'=>Request::path(),'files'=> true,'id'=>'form_reinscription')); ?>
            {{ Form::token() }}
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">
                    <div>
                        <button class="btn btn-sm btn-primary" type="submit" name="sauvegarder">
                            <i class="icon icon-save"></i> Réinscrire
                        </button>

                        <div class="options btn-group">
                            <a class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> Options</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo url('student/view/'.$eleve->id); ?>">
                                        <i class="icon-eye-open"></i> Afficher son profil</a>
                                </li>
                                <li>
                                    <a href="<?php echo url('student/add/'.$eleve->id); ?>">
                                        <i class="icon-pencil"></i> Editer</a>
                                </li>
                                <hr class="divider">
                                <li>
                                    <a href="<?php echo url('payment/list/'.$eleve->id); ?>">
                                        <i class="icon-money"></i> Frais de scolarité</a>
                                </li>
                                <hr class="divider">
                                <li>
                                    <a href="<?php echo url('student/list'); ?>">
                                        <i class="icon-reply"></i> Liste des élève</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div id="form-loader">

                        </div>
                        <br/>
                        <table class="table table-hover table-condensed table-responsive">

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <?php echo Form::label('periode_id','Session'); ?>
                                                <?php echo Form::select('periode_id',value(function() use($liste_periode,$eleve){
                                                    return $liste_periode;
                                                }),null,array('class'=>'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <?php echo Form::label('category_id','Categorie'); ?>
                                                <?php echo Form::select('category_id',$liste_categorie,
                                                    (!empty($eleve->category->id))?$eleve->category->id:'', array('class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group" id="classrooms">
                                                <?php echo Form::label('classroom_id','Classe'); ?>
                                                <?php echo Form::select('classroom_id',$liste_classe,null,array('class'=>'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="">
                                            <a class="btn btn-sm btn-default" href="{{url('student/add/'.$eleve->id)}}"><i class="icon icon-edit"></i> Modifier son profil</a>
                                        </p>
                                    </div>
                                </div>
                                <h3>{{$eleve->prenom}} {{$eleve->nom}}</h3>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <img style="width: 96%;" src="<?php if(isset($user) AND !empty($user->photo)){echo url('assets/img/users/'.$user->photo);}else{echo url('assets/img/users/avartarB.jpg');} ?>">
                                    </div>
                                    <div class="col-lg-7">

                                        <h4>Niveau :
                                            @if( !empty($eleve->category->nom) )
                                                {{$eleve->category->nom}}
                                            @else
                                                Aucun
                                            @endif
                                        </h4>
                                        <h4>Classe :
                                            @if( !empty($eleve->classroom->nom) )
                                                {{$eleve->classroom->nom}}
                                            @else
                                                Aucun
                                            @endif
                                        </h4>
                                        <hr/>
                                        <h4>Date de naissance : {{$eleve->date_naissance}}</h4>
                                        <h4>Adresse : {{$eleve->ville}}, {{$eleve->quartier}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>

<script>
    $(document).ready(function (){
        //$('#classrooms').empty().html('<i class="icon icon-spinner icon-spin icon-2x"></i> Chargement des classes en cours');
        var data = $('#form_reinscription').serialize();
        $.ajax({
            'url': '<?php echo url('student/get-liste-classroom/choix'); ?>',
            'type': 'POST',
            'dataType': 'html',
            'data': data,
            'success': function(data){
                $('#classrooms').empty().html(data);
            }
        });


        $('#category_id, #periode_id').change(function(){
            $('#classrooms').empty().html('<i class="icon icon-spinner icon-spin icon-2x"></i> Chargement des classes en cours');
            var data = $('#form_reinscription').serialize();
            $.ajax({
                'url': '<?php echo url('student/get-liste-classroom/choix'); ?>',
                'type': 'POST',
                'dataType': 'html',
                'data': data,
                'success': function(data){
                    $('#classrooms').empty().html(data);
                }
            });
        });

        $('#form_reinscription').submit(function(){
            $('#form-loader').empty().html('<i class="icon icon-spinner icon-spin icon-2x"></i> Enregistrement en cours');
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.ajax({
                'url': url,
                'data': data,
                'type': 'POST',
                'dataType': 'html',
                'success': function(data){
                    $('#form-loader').empty();
                    $('#alert').empty().html(data);
                }
            });
            return false;

        });
    });
</script>

@stop