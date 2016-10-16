@extends('tpl')

@section('content')


    <h1>{{$titre_page}}</h1>

    @include('produit.menu')

    @if(Session::has('liste_erreurs'))
    <div class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Attention!</strong> <a href="#" class="alert-link">{{current(Session::get('liste_erreurs')->all())}}
    </div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}. <a class="btn btn-sm btn-success" href="<?php echo url('produit/view/'.Session::get('id')); ?>">Voir la fiche du produit</a>
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

    @if(isset($produit))
    <p>
        <a class="btn btn-sm btn-info" href="{{ url('produit/view/'.$produit->id) }}">
            <i class="fa fa-eye"></i> Voir la fiche du produit
        </a>
    </p>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <?php echo Form::label('ref','Référence ou code barre'); ?>
            <?php echo Form::text('ref',Input::old('ref'),array('class'=>'form-control','placeholder'=>'Référence ou code barre')); ?>

            <?php echo Form::label('nom','Mom du produit'); ?>
            <?php echo Form::text('nom',Input::old('nom'),array('class'=>'form-control','placeholder'=>'Mom du produit')); ?>

            <?php echo Form::label('prix','Prix de vente'); ?>
            <div class="form-group input-group">
                <?php echo Form::text('prix',Input::old('prix'),array('class'=>'form-control','placeholder'=>'Prix de vente')); ?>
                <span class="input-group-addon"> {{Ets::get('devise')}}</span>
            </div>

            <?php echo Form::label('stock','Quantité en stock'); ?>
            <?php echo Form::text('stock',Input::old('stock'),array('class'=>'form-control','placeholder'=>'Quantité en stock')); ?>

            <?php echo Form::label('seuil_alert_stock','Seuil d\'alerte de stock'); ?>
            <?php echo Form::text('seuil_alert_stock',Input::old('seuil_alert_stock'),array('class'=>'form-control','placeholder'=>'Seuil d\'alerte de stock')); ?>

            <label for="expiration">Date d'expiration</label>
            <input type="date" name="expiration" class="form-control" value="<?php echo Input::old('expiration'); ?>" style="width: 150px;">
        </div>
        <div class="col-lg-4">
            <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php if(isset($produit) AND !empty($produit->photo)){echo url('assets/img/produits/'.$produit->photo); } ?>"></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file btn-default"><span class="fileupload-new">{{{ isset($produit) ? 'Modifier la photo' : 'Choisir une photo' }}}</span><span class="fileupload-exists">Change</span>
                    <input type="file" name="userfile"></span>
                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <?php echo Form::submit('Valider',array('class'=>'btn btn-primary')); ?>

    {{ Form::close() }}

    <style>
        label{
            margin-top: 20px;
        }
    </style>

@stop