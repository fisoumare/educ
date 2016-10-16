<hr style="border: dotted 1px #ccc; margin-top: 0; margin-bottom: 5px;">
<div class="row">
    <div class="col-lg-8" id="titre_article">
        @if(isset($client))
            <h3>{{ $client->nom }} {{$client->prenom}}</h3>
        @endif

    </div>
    <div class="col-lg-4">
        <p class="pull-right">
            <a href="<?php echo url('client/add'); ?>" class="btn btn-small btn-primary">Nouveau client</a>
            <a href="<?php echo url('client'); ?>" class="btn btn-small btn-default">Liste des clients</a>
        </p>

    </div>
</div>
<hr style="border: dotted 1px #ccc; margin-top: 0; margin-bottom: 5px;">