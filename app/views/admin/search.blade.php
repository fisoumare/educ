<div id="zone_recherche" class="row">
    <div class="col-lg-12">
        <div class="panel">
            <?php echo Form::open(array('url'=>'produit/list','class'=>'form-inline')); ?>
                <div class="row">
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary btn-small btn-default btn-block">Rechercher</button>
                    </div>
                    <div class="col-lg-4">
                        <?php echo Form::text('ref',Input::old('titre'),array('class' => 'form-control','placeholder' => 'Référence du produit')); ?>
                    </div>

                    <div class="col-lg-6">
                        <?php echo Form::text('nom',Input::old('nom'),array('class' => 'form-control','placeholder' => 'Nom du produit')); ?>
                    </div>
                </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
</div>