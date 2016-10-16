<hr style="border: dotted 1px #ccc; margin-top: 0; margin-bottom: 5px;">
<div class="row">
    <div class="col-lg-8" id="titre_article">
        @if(isset($produit))
            <h3>{{$produit->nom}}</h3>
        @endif

    </div>
    <div class="col-lg-4">
        <p class="pull-right">
            <?php if(CurrentUser::is_admin()): ?>
            <a href="<?php echo url('produit/add'); ?>" class="btn btn-small btn-primary">Nouveau produit</a>
            <?php endif ?>
            <a href="<?php echo url('produit'); ?>" class="btn btn-small btn-default">Liste des produits</a>
        </p>

    </div>
</div>
<hr style="border: dotted 1px #ccc; margin-top: 0; margin-bottom: 5px;">