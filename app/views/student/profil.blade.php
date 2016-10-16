@extends('tpl')

@section('content')

        <div class="col-lg-12">
            <h1 class="page_title">{{$page_title}}</h1>
            @if(Session::has('liste_erreurs'))
            <div class="alert alert-danger">
                <strong>Attention ! </strong> <a href="#" class="alert-link">{{current(Session::get('liste_erreurs')->all())}}</a>
            </div>
            @endif

            @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}.
            </div>
            @endif

            @if(Session::has('error'))
            <div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{Session::get('error')}}
            </div>
            @endif

            <?php echo Form::model($eleve,array('url'=>Request::path(),'files'=> true)); ?>
            {{ Form::token() }}
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">
                    <div class="">
                        <button class="btn btn-sm btn-primary" type="submit" name="sauvegarder">
                            <i class="icon icon-save"></i> Sauvegarder
                        </button>
                        <?php if( Request::segment(3) ): ?>
                            <div class="options btn-group">
                                <a class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> Options</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo url('student/view/'.$eleve->id); ?>">
                                            <i class="icon-eye-open"></i> Afficher son profil</a>
                                    </li>
                                    <hr class="divider">
                                    <li>
                                        <a href="<?php echo url('student/add/'.$eleve->id); ?>">
                                            <i class="icon-edit"></i> Editer</a>
                                    </li>
                                    <hr class="divider">
                                    <li>
                                        <a href="{{url('student/reinscription/'.$eleve->id)}}">
                                            <i class="icon-money"></i> Réinscrire pour Session</a>
                                    </li>
                                    <hr class="divider">
                                    <li>
                                        <a href="<?php echo url('student/list'); ?>">
                                            <i class="icon-reply"></i> Liste des élève</a>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                        <a class="btn btn-sm btn-default" href="{{url('student/list')}}"><i class="icon icon-reply"></i> Liste des élèves</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="row">
                            <div class="col-lg-9">
                                <h2>{{$eleve->prenom}} {{$eleve->nom}}</h2>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4>DATE DE NAISSANCE</h4>
                                        <p>{{$eleve->date_naissance}}</p>
                                        <hr/>

                                        <h4>LIEU DE NAISSANCE</h4>
                                        <p>{{$eleve->country->nom}} /
                                            @if( $eleve->country->nom == 'Guinea' )
                                                {{$eleve->city->nom}}
                                            @else
                                                {{$eleve->autre_ville_naissance}}
                                            @endif <br/>
                                            {{$eleve->quartier_naissance}}
                                        </p>
                                        <hr/>

                                        <h4>FILS DE</h4>
                                        <p>{{$eleve->prenom_pere}} {{$eleve->nom}}</p>
                                        <hr/>

                                        <h4>ET DE</h4>
                                        <p>{{$eleve->prenom_mere}} {{$eleve->nom_mere}}</p>
                                        <hr/>

                                        <h4>ADRESSE</h4>
                                        <p>{{$eleve->quartier}}</p>
                                        <hr/>

                                        <h4>TELEPHONE</h4>
                                        <p>{{$eleve->tel}}</p>
                                        <hr/>

                                        <h4>EMAIL</h4>
                                        <p>{{$eleve->email}}</p>
                                    </div>
                                    <div class="col-lg-6">

                                        <?php
                                        $periode = Periode::where('actif','oui')->first();
                                        $classe = Student::getHisClassroom($eleve->id,$periode->id); ?>
                                        <?php if( $classe != null ): ?>
                                            <h4>NIVEAU</h4>
                                            <p><?php echo $classe->category->nom; ?></p>
                                            <hr/>

                                            <h4>CLASSE</h4>
                                            <p><?php echo $classe->nom; ?></p>
                                        <?php else: ?>
                                            <h4>NIVEAU</h4>
                                            <p>Aucun pour la session {{$periode->interval}}</p>
                                            <hr/>

                                            <h4>CLASSE</h4>
                                            <p>Aucune pour la session {{$periode->interval}}</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <img class="img-circle img-responsive" src="<?php if(isset($eleve) AND !empty($eleve->photo)){echo url('assets/img/students/'.$eleve->photo);}else{echo url('assets/img/students/avartarB.jpg');} ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>

<script>
    $(document).ready(function (){
        $('#date').datepicker();
        $('.fileupload').fileupload();

        $('#autre_ville_naissance').hide();
        //Affichage des villes en fonction des lieux de naissances
        if($('#country_id').val() == 79) {
            $('#autre_ville_naissance').hide();
            $('#city_naissance_id').show();
        } else {
            $('#autre_ville_naissance').show();
            $('#city_naissance_id').hide();
        }

        $('#country_id').change(function(){
            if($(this).val() != 79 ) {
                $('#city_naissance_id').hide();
                $('#autre_ville_naissance').fadeIn();
            } else {
                $('#autre_ville_naissance').hide();
                $('#city_naissance_id').fadeIn();
            }
        });

        $('#nom').keyup(function(){
            $('#nom_pere').attr('value',$(this).val());
        });

        //Chargemet de la liste des classe en fonction des categories et des sessions================================================================================================
        $('#classrooms').empty().html('<i class="icon icon-spinner icon-spin icon-2x"></i> Chargement...');
        $.ajax({
            'url': '<?php echo url('student/get-liste-classroom/choix'); ?>',
            'type': 'POST',
            'dataType': 'html',
            'data': {periode_id:$('#periode_id').val(),category_id:$('#category_id').val()},
            'success': function(data){
                $('#classrooms').empty().html(data);
            }
        });

        $('body').on('change','#category_id, #periode_id',function(){
            $('#classrooms').empty().html('<i class="icon icon-spinner icon-spin icon-2x"></i> Chargement...');
            $.ajax({
                'url': '<?php echo url('student/get-liste-classroom/choix'); ?>',
                'type': 'POST',
                'dataType': 'html',
                'data': {periode_id:$('#periode_id').val(),category_id:$('#category_id').val()},
                'success': function(data){
                    $('#classrooms').empty().html(data);
                }
            });

        });

    });
</script>

@stop