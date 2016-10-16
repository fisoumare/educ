@extends('tpl')

@section('content')

        <div class="col-lg-12">
            <h1 class="page_title">Information</h1>
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">

                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel">
                        <div class="alert alert-info">
                            <h3>Information</h3>
                            <h4>Vous ne pouvez pas ajouter des <b>{{Session::get('entity')}}</b>  sans l'existence des <b>{{Session::get('needed_entity_alias_plural')}}</b>.</h4>
                            <p><a class="btn btn-primary" href="<?php echo url(Session::get('needed_entity_name').'/add'); ?>">Ajouter {{Session::get('needed_entity_alias_singular')}} maintenant</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@stop