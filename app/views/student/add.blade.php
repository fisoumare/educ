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
                                        <a href="<?php echo url('student/profil/'.$eleve->id); ?>">
                                            <i class="icon-eye-open"></i> Afficher son profil</a>
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
                <div class="col-lg-8">
                    <div class="panel">
                        <table class="table table-hover table-condensed table-responsive">

                            <?php if( Request::segment(3) ): ?>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <?php echo Form::label('periode_id','Modifier la session d\'inscription'); ?>
                                                    <?php echo Form::select('periode_id',$liste_periode,
                                                        DB::table('periode_student')->where('student_id','=',$eleve->id)->where('new','=',1)->pluck('periode_id'),
                                                        array('class'=>'form-control')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <?php echo Form::label('periode_id','Session'); ?>
                                                    <?php echo Form::select('periode_id',$liste_periode,Periode::where('actif','=','oui')->first()->id,array('class'=>'form-control')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php if( !Request::segment(3) ): ?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <?php echo Form::label('new','Cet élève appartient-il déja à '.Ets::get('nom').' ?'); ?>
                                                <div class="radio">
                                                    <label>
                                                        <?php echo Form::radio('new', 1, true); ?>
                                                        Non
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <?php echo Form::radio('new', 0); ?>
                                                        Oui
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('category_id','Categorie'); ?>
                                                <?php echo Form::select('category_id',$liste_categorie,null,array(
                                                    'class'=>'form-control',
                                                    'lien_ajax'=>url('student/get-liste-classroom'),
                                                    'classe_id'=>(Input::old('classroom_id')?Input::old('classroom_id'):'choix'))); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group" id="classrooms">
                                                <?php echo Form::label('classroom_id','Classe'); ?>
                                                <?php echo Form::select('classroom_id',array('choix'=>'Choisir une classe'),null,array('class'=>'form-control','disabled'=>'disabled')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <?php echo Form::label('sexe','Sexe ?'); ?>
                                                <div class="radio">
                                                    <label>
                                                        <?php echo Form::radio('sexe', 'm', true); ?>
                                                        Masculin
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <?php echo Form::radio('sexe', 'f'); ?>
                                                        Féminin
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('nom','Nom'); ?>
                                                <?php echo Form::text('nom',Input::old('nom'),array('class'=>'form-control','placeholder'=>'Nom','id'=>'nom')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('prenom','Prénom'); ?>
                                                <?php echo Form::text('prenom',Input::old('prenom'),array('class'=>'form-control','placeholder'=>'Prénom')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('date_naissance','Date de naissance'); ?>
                                                <?php echo Form::text('date_naissance',Input::old('date_naissance'),array('id'=>'date','class'=>'form-control','maxlength'=>'10','placeholder'=>'Date de naissance')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('country_id','Pays'); ?>
                                                <?php echo Form::select('country_id',$liste_pays,
                                                    (!empty($eleve->country_id))?$eleve->country_id:79,array('class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('city_naissance_id','Ville'); ?>
                                                <?php echo Form::select('city_naissance_id',$liste_ville,
                                                    ( $eleve->city_naissance_id )?$eleve->city_naissance_id:4, array('class' => 'form-control')); ?>
                                                <?php echo Form::text('autre_ville_naissance',Input::old('autre_ville_naissance'),array('class'=>'form-control','placeholder'=>'Ville','id'=>'autre_ville_naissance')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('quartier_naissance','Quartier/District'); ?>
                                                <?php echo Form::text('quartier_naissance',Input::old('quartier_naissance'),array('class'=>'form-control','placeholder'=>'Quartier/District')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('nom_pere','Nom du père'); ?>
                                                <?php echo Form::text('nom_pere',(!empty($eleve->nom))?$eleve->nom:Input::old('nom'),array('class'=>'form-control','placeholder'=>'Nom du père','id'=>'nom_pere','disabled'=>'disabled')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('prenom_pere','Prénom du père'); ?>
                                                <?php echo Form::text('prenom_pere',Input::old('prenom_pere'),array('class'=>'form-control','placeholder'=>'Prénom du père')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('nom_mere','Nom d la mère'); ?>
                                                <?php echo Form::text('nom_mere',Input::old('nom_mere'),array('class'=>'form-control','placeholder'=>'Nom de la mère')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('prenom_mere','Prénom de la mère'); ?>
                                                <?php echo Form::text('prenom_mere',Input::old('prenom_mere'),array('class'=>'form-control','placeholder'=>'Prénom de la mère')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('city_id','Ville'); ?>
                                                <?php echo Form::select('city_id',$liste_ville,
                                                    (!empty($eleve->city_id))?$eleve->city_id:4,array('class'=>'form-control')) ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('quartier','Quartier'); ?>
                                                <?php echo Form::text('quartier',Input::old('quartier'),array('class'=>'form-control','placeholder'=>'Quartier')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('tel','Téléphone'); ?>
                                                <?php echo Form::text('tel',Input::old('tel'),array('class'=>'form-control','placeholder'=>'Téléphone')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('email','E-mail'); ?>
                                                <?php echo Form::text('email',Input::old('email'),array('class'=>'form-control','placeholder'=>'E-mail')); ?>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
                        <div class="fileupload-new thumbnail" style="width: 100%; background-color: transparent; border: 0;">
                            <img class="img-circle img-responsive" src="<?php if(isset($eleve) AND !empty($eleve->photo)){echo url('assets/img/students/'.$eleve->photo);}else{echo url('assets/img/students/avartarB.jpg');} ?>">
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                    <span class="btn btn-file btn-default btn-block"><span class="fileupload-new">{{{ isset($user) ? 'Modifier la photo' : 'Choisir une photo' }}}</span><span class="fileupload-exists">Change</span>
                    <input type="file" name="userfile"></span>
                            <a href="#" class="btn btn-danger btn-block fileupload-exists" data-dismiss="fileupload">Supprimer</a>
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