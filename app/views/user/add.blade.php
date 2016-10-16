@extends('tpl')

@section('content')

    <div class="col-lg-12">
        <h1 class="page_title">{{$page_title}}</h1>

        @if(Session::has('liste_erreurs'))
        <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Attention ! </strong> <a href="#" class="alert-link">{{current(Session::get('liste_erreurs')->all())}}
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

        {{ Form::model($user,array('url'=>Request::url(),'files'=> true)) }}
        {{ Form::token() }}

        <div class="row">
            <?php if(CurrentUser::is_admin()): ?>
                <div class="col-lg-4">
                    <p>
                        <button class="btn btn-sm btn-primary" type="submit" name="sauvegarder"><i class="icon icon-save"></i> Sauvegarder</button>
                        <a href="<?php echo url('user/list'); ?>" class="btn btn-sm btn-default">Liste des utilisateurs</a>
                    </p>
                </div>
            <?php endif; ?>
        </div>


        <div class="row">
            <div class="col-lg-8">
                <div class="panel">
                    <fieldset>
                        <?php
                        //Un user ne peut pas modifier son propre type
                        if( CurrentUser::is_admin() AND (!isset($user) OR (isset($user) AND $user->id != Session::get('user_id'))) ): ?>
                            <?php echo Form::label('type','Type d\'utilisateur'); ?>
                            <?php echo Form::select('type',array('Gérant'=>'Gérant','Administrateur'=>'Administrateur'),'gerant',array('class'=>'form-control')); ?>
                            <br/>
                        <?php endif; ?>

                        <?php echo Form::label('identifiant','Identifant de connexion'); ?>
                        <?php echo Form::text('identifiant',Input::old('identifiant'),array('class'=>'form-control','placeholder'=>'Identifant de connexion')); ?>
                        <br/>

                        <?php echo Form::label('mdp','Mot de passe'); ?>
                        <?php echo Form::password('mdp',array('class'=>'form-control','placeholder'=>'Mot de passe')); ?>
                        <br/>

                        <?php echo Form::label('mdp_confirmation','Confirmer mot de passe'); ?>
                        <?php echo Form::password('mdp_confirmation',array('class'=>'form-control','placeholder'=>'Confirmer mot de passe')); ?>
                        <br/>

                        <?php echo Form::label('nom','Nom'); ?>
                        <?php echo Form::text('nom',Input::old('nom'),array('class'=>'form-control','placeholder'=>'Mom')); ?>
                        <br/>

                        <?php echo Form::label('prenom','Prénom'); ?>
                        <?php echo Form::text('prenom',Input::old('prenom'),array('class'=>'form-control','placeholder'=>'Prénom')); ?>
                        <br/>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php if(isset($user) AND !empty($user->photo)){echo url('assets/img/users/'.$user->photo);}else{echo url('assets/img/users/avartarB.jpg');} ?>"></div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div>
                    <span class="btn btn-file btn-default"><span class="fileupload-new">{{{ isset($user) ? 'Modifier la photo' : 'Choisir une photo' }}}</span><span class="fileupload-exists">Change</span>
                    <input type="file" name="userfile"></span>
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}

    </div>


@stop