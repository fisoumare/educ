<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url'=>'vente/view')) }}
        {{ Form::token() }}
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group input-group">
                        <span class="input-group-addon">Jour</span>
                        <?php echo Form::select(
                            'jour',FormatDate::jours_du_mois('aucun','Tout'),
                            value(function(){
                                if(Session::has('histo_search')){
                                    if(Session::has('histo_search.jour')){
                                        return Session::get('histo_search.jour');
                                    }
                                    else{
                                        return 'aucun';
                                    }
                                }
                                else{
                                    return date('d');
                                }
                            }),
                            array('class'=>'form-control')); ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group input-group">
                        <span class="input-group-addon">Mois</span>
                        <?php echo Form::select('mois',FormatDate::mois('aucun','Tout'),
                            value(function(){
                                if(Session::has('histo_search')){
                                    if(Session::has('histo_search.mois')){
                                        return Session::get('histo_search.mois');
                                    }
                                    else{
                                        return 'aucun';
                                    }
                                }
                                else{
                                    return date('m');
                                }
                            }),
                            array('class'=>'form-control')); ?>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group input-group">
                        <span class="input-group-addon">Année</span>
                        <?php echo Form::select('annee',FormatDate::annee('aucun','Tout'),
                            value(function(){
                                if(Session::has('histo_search')){
                                    if(Session::has('histo_search.annee')){
                                        return Session::get('histo_search.annee');
                                    }
                                    else{
                                        return 'aucun';
                                    }
                                }
                                else{
                                    return date('Y');
                                }
                            }),
                            array('class'=>'form-control')); ?>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group input-group">
                        <span class="input-group-addon">Heure min</span>
                        <input type="time" name="hmin" class="form-control" value="<?php
                        echo value(function(){
                            if(Session::has('histo_search.hmin')){
                                return Session::get('histo_search.hmin');
                            }
                        });
                        ?>">
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group input-group">
                        <span class="input-group-addon">Heure max</span>
                        <input type="time" name="hmax" class="form-control" value="<?php
                        echo value(function(){
                            if(Session::has('histo_search.hmax')){
                                return Session::get('histo_search.hmax');
                            }
                        });
                        ?>">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button class="btn btn-primary" type="submit" name="valider" value="select">
                       <i class="fa fa-search"></i> Afficher
                    </button>
                    <button class="btn btn-success" type="submit" name="valider" value="tout">
                        <i class="fa fa-list-alt"></i> Afficher toute l'historique
                    </button>
                    <button class="btn btn-default" type="submit" name="valider" value="today">
                        <i class="fa fa-refresh"></i> Aujourd'hui
                    </button>
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
<hr style="border: dotted 1px #ccc; margin-top: 3px; margin-bottom: 2px;">
<div class="row">
    <div class="col-lg-6">

        <div class="alert alert-info">
            <h4>Liste de toutes les ventes</h4>
            <?php if( Session::has('histo_search') ): ?>

                <?php if( Session::has('histo_search.debut') AND Session::has('histo_search.fin') ): ?>
                    <p>Entre <?php echo FormatDate::lettres(Session::get('histo_search.debut'),true); ?>
                        et <?php echo FormatDate::lettres(Session::get('histo_search.fin'),true); ?></p>
                <?php else: ?>
                    <p>Toutes les périodes.</p>
                <?php endif; ?>

            <?php else: ?>
                <p>Aujourd'hui le <?php echo FormatDate::lettres(date('Y-m-d')) ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="alert alert-<?php
        if( Session::has('histo_search.isday') AND Cloture::IsClotured(Session::get('histo_search.isday')) ){
            echo 'success';
        }
        else{
            echo 'warning';
        }
        ?>" style="font-size: 35px; color: #000000;">
            <?php if( Session::has('histo_search.isday') AND Cloture::IsClotured(Session::get('histo_search.isday')) ): ?>
                    <i class="fa fa-check"></i>
            <?php endif; ?>

            Revenu : {{ $revenu or '0' }} {{Ets::get('devise')}}
        </div>
    </div>
</div>


<?php if( Session::has('isday') ): ?>
    <?php if( CurrentUser::is_admin() AND !Cloture::IsClotured(Session::get('isday')) ): ?>
        <hr style="border: dotted 1px #ccc; margin-top: 3px; margin-bottom: 5px;">
        <div class="row" style="margin-bottom: 5px;">
            <div class="col-lg-2">
                    <button data-toggle="modal" href="#cloture_jour" class="btn btn-warning btn-block">
                       <i class="fa fa-check"></i> Valider le jour</button>
            </div>
            <div class="col-lg-10">
                <div class="alert alert-warning" style="padding-top: 6px; padding-bottom: 6px;">
                    <strong>Avertissement ! Si vous validez le revenu d'un jour, il vous sera impossible de le modifier.</strong>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

