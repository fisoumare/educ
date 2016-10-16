@if(isset($produit))
<hr style="border: dotted 1px #ccc; margin-top: 0; margin-bottom: 5px;">
<div class="row">
    <div class="col-lg-12">
        <h3 style="margin-top: 5px;"><span style="font-size: 24px;" class="label label-info">{{ $produit->prix }} {{Ets::get('devise')}} </span> |
        {{ $produit->nom }}</h3>
    </div>
</div>
<hr style="border: dotted 1px #ccc; margin-top: 5px; margin-bottom: 5px;">
<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url'=>'vente/add')) }}
            {{ Form::token() }}
            <input type="hidden" name="produit_id" value="{{$produit->id}}">
            <div class="row">
                <div class="col-lg-2">
                    <?php echo Form::text('quantite',Input::old('quantite'),array('class'=>'form-control','placeholder'=>'Quantité')); ?>
                </div>
                <div class="col-lg-3">
                    <div class="form-group input-group">
                        <?php echo Form::text('prix',Input::old('prix',$produit->prix),array('class'=>'form-control','placeholder'=>'Prix de vente')); ?>
                        <span class="input-group-addon"> {{Ets::get('devise')}}</span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group input-group">
                        <?php echo Form::text('remise',Input::old('remise'),array('class'=>'form-control','placeholder'=>'Remise')); ?>
                        <span class="input-group-addon"> %</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php echo Form::select('client',$liste_client,'',array('class'=>'form-control')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <button type="submit" name="action_vendre" value="confirmer" class="btn btn-small btn-success">Confirmer</button>
                    <button type="submit" name="action_vendre" value="ajouter_panier" class="btn btn-small btn-warning">Au panier</button>
                    <button style="display: none;" type="submit" name="action_vendre" value="commande" class="btn btn-small btn-default">Commande</button>
                </div>
            </div>
        {{ Form::close() }}

    </div>
</div>
<hr style="border: dotted 1px #ccc; margin-top: 5px; margin-bottom: 5px;">


@endif