@extends('tpl')

@section('content')
        <div class="col-lg-12">

            @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}.
            </div>
            @endif

            @if( isset($success) )
            <div class="alert alert-success">
                {{ $success }}.
            </div>
            @endif

            @if(Session::has('info'))
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{Session::get('info')}}
            </div>
            @endif

            @if(Session::has('error'))
            <div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{Session::get('error')}}
            </div>
            @endif

            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">
                    <div>
                        <div class="options btn-group">
                            <a class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> Options</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo url('student/profil/'.$eleve->id); ?>">
                                        <i class="icon-eye-open"></i> Afficher son profil</a>
                                </li>
                                <hr class="divider"/>
                                <li>
                                    <a href="<?php echo url('student/add/'.$eleve->id); ?>">
                                        <i class="icon-pencil"></i> Editer</a>
                                </li>
                                <hr class="divider">
                                <li>
                                    <a href="{{url('student/reinscription/'.$eleve->id)}}">
                                        <i class="icon-money"></i> Réinscrire pour Session</a>
                                </li>
                                <hr class="divider">
                                <li>
                                    <a href="{{'student/list'}}">
                                        <i class="icon-reply"></i> Liste des élèves</a>
                                </li>
                            </ul>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel" style="padding-top: 0; padding-bottom: 0;">
                        <h3>{{$eleve->prenom}} {{$eleve->nom}} ({{$classe->nom}}) - Frais de scolarité Session {{$periode->interval}}</h3>
                        <p>
                            <span class="badge">
                                Montant de la scolarité de la classe {{$classe->nom}} : {{$montant_frais_scolarite}}
                            </span>
                        </p>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="panel panel-primary" style="box-shadow: none; height: 140px;">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            Effectuer un versement
                                        </h4>
                                    </div>

                                    <?php echo Form::open(array('url'=>'payment/process/'.$eleve->id.'/'.$periode->id)); ?>
                                    {{ Form::token() }}

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button type="submit" name="valider" class="btn btn-lg btn-primary">
                                                            <i class="icon icon-ok"></i> OK
                                                        </button>
                                                    </span>
                                                    <?php echo Form::text('montant',null,array('class'=>'form-control input-lg','maxlength'=>'10')); ?>
                                                    <span class="input-group-addon">GNF</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">

                                        </div>
                                    </div>

                                    <?php echo Form::close(); ?>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-success" style="box-shadow: none; height: 140px;">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            Payé
                                        </h4>
                                    </div>
                                    <h2><?php echo number_format($montant,2,',','.'); ?> GNF</h2>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-danger" style="box-shadow: none; height: 140px;">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            Reste à payer
                                        </h4>
                                    </div>
                                    <h2><?php echo number_format($reliquat,2,',','.'); ?> GNF</h2>
                                </div>
                            </div>
                        </div>

                        <hr/>

                        <div class="row">
                            <?php if(count($liste_payment) > 0): ?>
                                <div class="col-lg-5">
                                    <div class="panel" style="box-shadow: none;">
                                        <div class="panel-heading">
                                            <h4>Liste des mois</h4>
                                        </div>
                                        <table class="table">
                                            <?php
                                            $liste_mois = FormatDate::getSessionMonthsList($periode->debut,$periode->fin);
                                            $i = 1;
                                            foreach( $liste_mois as $mois ): ?>
                                                <?php if( $i == count($liste_mois) AND $nbre_mois_paye >= 2): ?>
                                                    <tr class="alert alert-success">
                                                        <td>
                                                                <i class="icon icon-ok"></i>
                                                        </td>
                                                        <td style="text-align: right;">{{$mois}} {{$i}}</td>
                                                    </tr>
                                                <?php elseif( ($nbre_mois_paye == 1 AND $i==1) OR $i <= ($nbre_mois_paye-1) ): ?>
                                                    <tr class="alert alert-success">
                                                        <td>
                                                            <?php if($i<=$nbre_mois_paye): ?>
                                                                <i class="icon icon-ok"></i>
                                                            <?php else: ?>
                                                                <i class="icon icon-ban-circle"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="text-align: right;">{{$mois}}</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr>
                                                        <td>
                                                            <i class="icon icon-ban-circle"></i>
                                                        </td>
                                                        <td style="text-align: right;">{{$mois}}</td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php $i++; endforeach; ?>
                                        </table>
                                    </div>

                                </div>

                                <div class="col-lg-7">
                                    <div class="panel" style="box-shadow: none;">
                                        <div class="panel-heading">
                                            <h4>Historique des paiments</h4>
                                        </div>

                                        <table class="table table-stripped">
                                            <tr>
                                                <td><b>#</b></td>
                                                <td><b>Date de versement</b></td>
                                                <td><b>Montant</b></td>
                                                <td></td>
                                            </tr>
                                            <?php $i=1; foreach( $liste_payment as $p ): ?>
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td class="montant_date"><?php echo FormatDate::lettres($p->created_at,true); ?></td>
                                                    <td class="montant"><?php echo $p->montant; ?></td>
                                                    <td style="min-width: 150px;">
                                                        <div class="options btn-group pull-right">
                                                            <a class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> Options</a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="modifier" data-toggle="modal" href="#modifier" lien="<?php echo url('payment/edit/'.$p->id.'/'.$eleve->id); ?>">
                                                                        <i class="icon-pencil"></i> Editer</a>
                                                                </li>
                                                                <hr class="divider">
                                                                <li>
                                                                    <a class="supprimer" data-toggle="modal" href="#supprimer" lien="<?php echo url('payment/delete/'.$p->id.'/'.$eleve->id); ?>" >
                                                                        <i class="icon-trash"></i> Supprimer</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php $i++; endforeach; ?>
                                        </table>
                                    </div>
                                </div>
                                <?php else: ?>
                                    <div class="col-lg-12">
                                        <div class="alert alert-dismissable alert-info">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>Aucun paiement dans la liste.</strong>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="modal fade" id="modifier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 id="date_historique" class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <form id="modifier_historique" action="" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input id="montant_historique" type="text" name="montant" class="form-control"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit" name="confirmer"><i class="icon icon-edit"></i> Confirmer</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="modal fade" id="supprimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Vous êtes sur le point de supprimer un paiement déja effectué</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger">Etes-vous sûr de vouloir supprimer ce paiement ?</div>
                            <hr/>
                            <button type="button" class="btn btn-small btn-primary" data-dismiss="modal">Annuler</button>
                            <a href="#" class="btn btn-danger" id="action_supprimer_historique">
                                <i class="fa fa-trash-o"></i> Supprimer</a>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <script type="text/javascript">
                $(document).ready(function(){
                    $('.modifier').click(function(){
                        var montant = $(this).parents('tr').find('td.montant').html();
                        var date = $(this).parents('tr').find('td.montant_date').html();

                        $('#montant_historique').val(montant);
                        $('#date_historique').html('Modification du payement de la date '+date);
                        $('#modifier_historique').attr('action',$(this).attr('lien'));
                    });

                    $('.supprimer').click(function(){
                        $('#action_supprimer_historique').attr('href',$(this).attr('lien'));
                    });
                });
            </script>

        </div>

@stop