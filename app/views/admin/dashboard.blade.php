@extends('tpl')

@section('content')

        <div class="col-lg-12">
            <h1 class="page_title">Tableau de bord</h1>
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        @if( $current_periode != null )
                        <h2>Session {{$current_periode->interval}}</h2>
                        @endif
                        <hr style="margin-top: 5px; margin-bottom: 5px;" />
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-primary" style="box-shadow: none;">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    Nombre d'élèves
                                                </h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="alert alert-success"><h1>{{$nbre_eleve}} élèves</h1></div>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nombre de Garçons</td>
                                                            <td>{{$nbre_eleve_garcon}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nombre de filles</td>
                                                            <td>{{$nbre_eleve_fille}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div id="flot-placeholder" style="width:300px;height:200px"></div>

                                                    <script type="text/javascript">
                                                        $(document).ready(function(){
                                                            var data = [
                                                                { label: "Garçons",  data: <?php echo $nbre_eleve_garcon; ?>},
                                                                { label: "filles",  data: <?php echo $nbre_eleve_fille; ?>},
                                                            ];

                                                            $.plot($("#flot-placeholder"), data,{
                                                                series: {
                                                                    pie: {
                                                                        innerRadius: 0.5,
                                                                        radius: 1,
                                                                        label: {
                                                                            show: true,
                                                                            radius: 1,
                                                                            background: {
                                                                                color: '#333',
                                                                                opacity: 0.8
                                                                            }
                                                                        },
                                                                        show: true
                                                                    }
                                                                }
                                                            });
                                                            //$("#flot-placeholder").showMemo();
                                                        });

                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-primary" style="box-shadow: none;">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    Revenu actuel de l'école
                                                </h4>
                                            </div>
                                            <div class="alert alert-success">
                                                <h1><?php echo number_format(($revenu + $revenu_inscription + $revenu_reinscription),2,',','.').' '.Ets::get('devise'); ?></h1>
                                            </div>

                                            <table class="table">
                                                <tr>
                                                    <td>Revenu brut</td>
                                                    <td>
                                                        <?php echo number_format($revenu,2,',','.').' '.Ets::get('devise'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Revenu des inscriptions</td>
                                                    <td>
                                                        <?php echo number_format(($revenu_inscription + $revenu_reinscription) ,2,',','.').' '.Ets::get('devise'); ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-primary" style="box-shadow: none;">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    Revenu des inscriptions
                                                </h4>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="alert alert-success"><h1><?php echo number_format(($revenu_inscription + $revenu_reinscription),2,',','.').' '.Ets::get('devise'); ?></h1></div>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Inscrits</td>
                                                            <td>
                                                                <?php echo number_format($revenu_inscription ,2,',','.').' '.Ets::get('devise'); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Réinscrits</td>
                                                            <td>
                                                                <?php echo number_format($revenu_reinscription ,2,',','.').' '.Ets::get('devise'); ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div id="flot-placeholder-inscription" style="width:300px;height:200px"></div>

                                                    <script type="text/javascript">
                                                        $(document).ready(function(){
                                                            var data_inscription = [
                                                                { label: "Inscrits",  data: <?php echo $revenu_inscription; ?>},
                                                                { label: "Réinscrits",  data: <?php echo $revenu_reinscription; ?>},
                                                            ];

                                                            $.plot($("#flot-placeholder-inscription"), data_inscription,{
                                                                series: {
                                                                    pie: {
                                                                        innerRadius: 0.5,
                                                                        radius: 1,
                                                                        label: {
                                                                            show: true,
                                                                            radius: 1,
                                                                            background: {
                                                                                color: '#333',
                                                                                opacity: 0.8
                                                                            }
                                                                        },
                                                                        show: true
                                                                    }
                                                                }
                                                            });
                                                            //$("#flot-placeholder").showMemo();
                                                        });

                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

@stop