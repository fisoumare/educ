@extends('tpl')

@section('content')

        <div class="col-lg-12">
            <h1 class="page_title">Configuration</h1>
            @if(Session::has('liste_erreurs'))
            <div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Attention!</strong> {{current(Session::get('liste_erreurs')->all())}}
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

            <?php echo Form::model($config,array('url'=>Request::url(),'files'=> true)); ?>
            {{ Form::token() }}

            <div class="row">
                <div class="col-lg-12">
                    <p>
                        <button class="btn btn-sm btn-primary" type="submit" name="sauvegarder"><i class="icon icon-save"></i> Sauvegarder</button>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                   <div class="panel">
                       <div class="row">
                           <div class="col-lg-12">
                               <div class="form-group">
                                   <?php echo Form::label('nom','Nom de votre établissement'); ?>
                                   <?php echo Form::text('nom',Input::old('nom'),array('class'=>'form-control','placeholder'=>'Nom de votre établissement')); ?>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12">
                               <div class="form-group">
                                   <?php echo Form::label('adresse','Adresse'); ?>
                                   <?php echo Form::text('adresse',Input::old('adresse'),array('class'=>'form-control','placeholder'=>'Adresse')); ?>
                               </div>
                           </div>
                       </div>

                       <div class="row">
                           <div class="col-lg-12">
                               <div class="form-group">
                                   <?php echo Form::label('tel','Téléphone'); ?>
                                   <?php echo Form::text('tel',Input::old('tel'),array('class'=>'form-control','placeholder'=>'Téléphone')); ?>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12">
                               <div class="form-group">
                                   <?php echo Form::label('email','E-mail'); ?>
                                   <?php echo Form::text('email',Input::old('email'),array('class'=>'form-control','placeholder'=>'E-mail')); ?>
                               </div>
                           </div>
                       </div>

                       <div class="row">
                           <div class="col-lg-12">
                               <div class="form-group">
                                   <?php echo Form::label('devise','Symbol devise'); ?>
                                   <?php echo Form::text('devise',Input::old('devise'),array('class'=>'form-control','placeholder'=>'GNF')); ?>
                               </div>
                           </div>
                       </div>

                       <div class="row">
                           <div class="col-lg-12">
                               <div class="form-group">
                                   <?php echo Form::label('scolarite','Montant par défaut de la scolarité'); ?>
                                   <div class="input-group">
                                       <?php echo Form::text('scolarite',Input::old('scolarite'),array('class'=>'form-control','placeholder'=>'Montant de la scolarité')); ?>
                                       <span class="input-group-addon">
                                            {{Ets::get('devise')}}
                                        </span>
                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="row">
                           <div class="col-lg-12">
                               <div class="form-group">
                                   <?php echo Form::label('montant_inscription','Montant par défaut des frais d\'inscription'); ?>
                                   <div class="input-group">
                                       <?php echo Form::text('montant_inscription',Input::old('montant_inscription'), array('class' => 'form-control', 'placeholder'=>'Montant par défaut des frais d\'inscription')); ?>
                                       <span class="input-group-addon">
                                            {{Ets::get('devise')}}
                                        </span>
                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="row">
                           <div class="col-lg-12">
                               <div class="form-group">
                                   <?php echo Form::label('montant_reinscription','Montant par défaut des frais de réinscription'); ?>
                                   <div class="input-group">
                                       <?php echo Form::text('montant_reinscription',Input::old('montant_reinscription'), array('class' => 'form-control', 'placeholder'=>'Montant par défaut des frais de réinscription')); ?>
                                       <span class="input-group-addon">
                                            {{Ets::get('devise')}}
                                        </span>
                                   </div>
                               </div>
                           </div>
                       </div>


                   </div>
                </div>
                <div class="col-lg-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php if(isset($config) AND !empty($config->photo)){echo url('assets/img/'.$config->photo);} ?>"></div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                    <span class="btn btn-file btn-default"><span class="fileupload-new">{{{ isset($user) ? 'Modifier le logo' : 'Choisir un logo' }}}</span><span class="fileupload-exists">Change</span>
                    <input type="file" name="userfile"></span>
                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>

@stop