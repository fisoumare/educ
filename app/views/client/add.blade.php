@extends('tpl')

@section('content')


    <h1>{{$titre_page}}</h1>

    @include('client.menu')

    @if(Session::has('liste_erreurs'))
    <div class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Oh snap!</strong> <a href="#" class="alert-link">{{current(Session::get('liste_erreurs')->all())}}
    </div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}. <a class="btn btn-sm btn-success" href="<?php echo url('client/view/'.Session::get('id')); ?>">Voir le profil du client</a>
    </div>
    @endif

    @if(Session::has('error'))
    <div class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{Session::get('error')}}
    </div>
    @endif

    {{ Form::open(array('url'=>Request::url(),'files'=> true)) }}
    {{ Form::token() }}

    @if(isset($client))
    <p>
        <a class="btn btn-sm btn-info" href="{{ url('client/view/'.$client->id) }}">
            <i class="fa fa-eye"></i> Voir le profil du client
        </a>
    </p>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <fieldset>
                <legend>Informations personnelles</legend>
                <?php echo Form::label('sexe','Femme'); ?>
                <?php echo Form::radio('sexe','f',array('class'=>'form-control')); ?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <?php echo Form::label('sexe','Homme'); ?>
                <?php echo Form::radio('sexe','h',array('class'=>'form-control')); ?><br>

                <?php echo Form::label('nom','Nom'); ?>
                <?php echo Form::text('nom',Input::old('nom'),array('class'=>'form-control','placeholder'=>'Mom')); ?>

                <?php echo Form::label('prenom','Prénom'); ?>
                <?php echo Form::text('prenom',Input::old('prenom'),array('class'=>'form-control','placeholder'=>'Prénom')); ?>
            </fieldset>

            <fieldset ma>
                <legend>Contacts</legend>
                <?php echo Form::label('adresse','Adresse'); ?>
                <?php echo Form::text('adresse',Input::old('adresse'),array('class'=>'form-control','placeholder'=>'Adresse')); ?>

                <?php echo Form::label('tel','Téléphone'); ?>
                <?php echo Form::text('tel',Input::old('tel'),array('class'=>'form-control','placeholder'=>'Téléphone')); ?>

                <?php echo Form::label('email','E-mail'); ?>
                <?php echo Form::email('email',Input::old('email'),array('class'=>'form-control','placeholder'=>'E-mail')); ?>
            </fieldset>
        </div>
        <div class="col-lg-4">
            <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php if(isset($client) AND !empty($client->photo)){echo url('assets/img/clients/'.$client->photo); } ?>"></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file btn-default"><span class="fileupload-new">{{{ isset($client) ? 'Modifier la photo' : 'Choisir une photo' }}}</span><span class="fileupload-exists">Change</span>
                    <input type="file" name="userfile"></span>
                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                </div>
            </div>
        </div>
    </div>

    <?php echo Form::submit('valider',array('class'=>'btn btn-primary')); ?>

    {{ Form::close() }}

@stop