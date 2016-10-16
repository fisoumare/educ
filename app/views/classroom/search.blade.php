<div id="zone_recherche" class="row">
    <div class="col-lg-12">
        <div class="panel">
            <?php echo Form::open(array('url'=>'user/list','class'=>'form-inline')); ?>
                <div class="row">
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary btn-small btn-default btn-block">Rechercher</button>
                    </div>
                    <div class="col-lg-10">
                        <?php echo Form::text('nom',Input::old('nom'),array('class' => 'form-control','placeholder' => 'Nom de l\'utilisateur')); ?>
                    </div>
                </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
</div>