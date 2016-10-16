@extends('tpl')

@section('content')

        <div class="col-lg-12">
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

            <?php echo Form::model($classe,array('url'=>Request::path(),'files'=> true)); ?>
            {{ Form::token() }}
            <div class="row">
                <div class="col-lg-12">
                    <p class="">
                        <button class="btn btn-sm btn-primary" type="submit" name="sauvegarder">
                            <i class="icon icon-save"></i> Sauvegarder
                        </button>
                        <a class="btn btn-sm btn-default" href="{{url('classroom/list')}}"><i class="icon icon-reply"></i> Liste des classes</a>
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
                                                <?php echo Form::label('session','Session'); ?>
                                                <?php echo Form::select('session',FormatDate::getSession(),null,array('class'=>'form-control')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo Form::label('category_id','Catégorie'); ?>
                                                <?php echo Form::select('category_id',$liste_categorie,null,array('class'=>'form-control')); ?>
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
                                                <?php echo Form::label('nom','Nom de la classe'); ?>
                                                <?php echo Form::text('nom',Input::old('nom'),array('class'=>'form-control','placeholder'=>'Nom','id'=>'nom')); ?>
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
                                                <?php echo Form::label('scolarite','Montant de la scolarité en '.Ets::get('devise')); ?>
                                                <?php echo Form::text('scolarite',(!empty($classe->scolarite))?$classe->scolarite:(Input::old('scolarite'))?Input::old('scolarite'):Ets::get('scolarite'),array('class'=>'form-control','placeholder'=>'Montant de la scolarité en GNF','id'=>'nom')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel">
                        <h4>Aide</h4>
                        <div class="alert alert-info">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt eos excepturi illo maxime minima non possimus quisquam similique! Adipisci eius eum iste maxime minus mollitia nemo officiis quo! Alias at fugiat officia placeat unde! Asperiores delectus, deleniti dignissimos, dolore dolorem doloremque doloribus enim facilis labore obcaecati, optio ratione saepe voluptatem? Aspernatur cum, fuga maiores officia quae qui vitae voluptas. Aperiam dignissimos dolor fugit obcaecati. Accusamus amet animi asperiores atque aut consequatur dicta dolores earum et eum excepturi fugit illo in labore modi molestiae necessitatibus, non nostrum obcaecati odit optio perspiciatis quaerat repellendus sequi ullam unde ut! Atque iste odit temporibus!</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>

<script>
    $(document).ready(function (){
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

    });
</script>

@stop