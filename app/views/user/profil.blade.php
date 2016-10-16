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

            <?php echo Form::model($user,array('url'=>Request::path(),'files'=> true)); ?>
            {{ Form::token() }}
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">
                    <p>
                    <?php if(CurrentUser::is_admin()): ?>
                        <a href="<?php echo url('user/add'); ?>" class="btn btn-sm btn-primary">Nouvel utilisateur</a>
                    <?php endif; ?>
                        <a href="<?php echo url('user/list'); ?>" class="btn btn-sm btn-default">Liste des utilisateurs</a>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel">
                        <div class="row">
                            <div class="col-lg-9">
                                <h2>{{$user->prenom}} {{$user->nom}}</h2>
                                <hr/>
                                    <h4>TYPE</h4>
                                    <p>{{$user->type}}</p>
                                    <hr/>

                                    <h4>IDENTIFIANT DE CONNEXION</h4>
                                    <p>{{$user->identifiant}}</p>
                                    <hr/>

                                    <h4>DATE DE CREATION</h4>
                                    <p>{{$user->created_at}}</p>
                                    <hr/>

                                    <h4>DERNIERE MODIFICATION</h4>
                                    <p>{{$user->updated_at}}</p>

                            </div>
                            <div class="col-lg-3">
                                <?php if(!empty($user->photo)): ?>
                                    <img class="img-circle img-responsive" src="<?php echo url('assets/img/users/'.$user->photo); ?>" alt="<?php echo $user->nom; ?>"/>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
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