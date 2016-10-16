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

            <?php echo Form::model($periode,array('url'=>Request::path(),'files'=> true)); ?>
            {{ Form::token() }}
            <div class="row">
                <div class="col-lg-12">
                    <p class="">
                        <button class="btn btn-sm btn-primary" type="submit" name="sauvegarder">
                            <i class="icon icon-save"></i> Sauvegarder
                        </button>
                        <a class="btn btn-sm btn-default" href="{{url('periode/list')}}"><i class="icon icon-reply"></i> Liste des Sessions</a>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel">
                        <table class="table table-hover table-condensed table-responsive">
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('nom','Nom de la Session (Facultatif)'); ?>
                                                <?php echo Form::text('nom',Input::old('nom'),array('class'=>'form-control','placeholder'=>'Nom','id'=>'nom')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('interval','Période'); ?>
                                                <?php echo Form::select('interval',FormatDate::getSession(),null,array('class'=>'form-control')); ?>
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
                                                <?php echo Form::label('debut','Date début de la session'); ?>
                                                <?php echo Form::text('debut',Input::old('debut'),array('id'=>'debut','class'=>'form-control','placeholder'=>'Date de début')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('fin','Date fin de la session'); ?>
                                                <?php echo Form::text('fin',Input::old('fin'),array('id'=>'fin','class'=>'form-control','placeholder'=>'Date de fin')); ?>
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
                                                <?php echo Form::label('debut_payement','Date de début des paiements '); ?>
                                                <?php echo Form::select('debut_payement',FormatDate::moisEnTableau(true),
                                                    ( !empty($periode->debut_payement) )?$periode->debut_payement:'10',array('class'=>'form-control')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('fin_payement','Date de fin des paiements '); ?>
                                                <?php echo Form::select('fin_payement',FormatDate::moisEnTableau(true),
                                                    ( !empty($periode->fin_payement) )?$periode->fin_payement:'10',array('class'=>'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <?php echo Form::label('scolarite','Montant par défaut de la scolarité'); ?>
                                                <div class="input-group">
                                                    <?php echo Form::text('scolarite',($periode->scolarite)?$periode->scolarite:(Input::old('scolarite'))?Input::old('scolarite'):Ets::get('scolarite'),
                                                        array('class'=>'form-control','placeholder'=>'Montant par défaut de la scolarité')); ?>
                                                    <span class="input-group-addon">
                                                        {{Ets::get('devise')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <?php echo Form::label('montant_inscription','Montant par défaut des frais d\'inscription'); ?>
                                                <div class="input-group">
                                                    <?php echo Form::text('montant_inscription',($periode->montant_inscription)?$periode->montant_inscription:(Input::old('montant_inscription'))?Input::old('montant_inscription'):Ets::get('montant_inscription'),
                                                        array('class'=>'form-control','placeholder'=>'Montant par défaut des frais d\'inscription')); ?>
                                                    <span class="input-group-addon">
                                                        {{Ets::get('devise')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <?php echo Form::label('montant_reinscription','Montant par défaut des frais de réinscription'); ?>
                                                <div class="input-group">
                                                    <?php echo Form::text('montant_reinscription',($periode->montant_reinscription)?$periode->montant_reinscription:(Input::old('montant_reinscription'))?Input::old('montant_reinscription'):Ets::get('montant_reinscription'),
                                                        array('class'=>'form-control','placeholder'=>'Montant par défaut des frais de réinscription')); ?>
                                                    <span class="input-group-addon">
                                                        {{Ets::get('devise')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <?php if( !Request::segment(3) ): ?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5>Définir comme Session courante ?</h5>
                                            <h5>
                                                <?php echo Form::radio('actif','oui',array('class'=>'form-control')); ?>
                                                Oui
                                            </h5>
                                            <h5>
                                                <?php echo Form::radio('actif','non',array('class'=>'form-control')); ?>
                                                Non
                                            </h5>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5>Lier automatiquent toutes les données de l'Etablissement à cette Session ?</h5>
                                            <h5>
                                                <?php echo Form::radio('lier','oui',true); ?>
                                                Oui, les lier automatiquement
                                            </h5>
                                            <h5>
                                                <?php echo Form::radio('lier','non'); ?>
                                                Non, je le ferai manuellement
                                            </h5>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">

                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>

<script>
    $(document).ready(function (){
        $('#debut, #fin').datepicker();

    });
</script>

@stop