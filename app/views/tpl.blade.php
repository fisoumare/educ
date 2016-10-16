<!DOCTYPE html>
<html lang="en">
  <head>
        @include('header')
  </head>

  <body>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel" style="margin-top: 10px; padding-top: 10px; padding-bottom: 2px;">
                    <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <?php if( Ets::get('photo') ): ?>
                                <img style="width: 90px;" src="<?php echo url('assets/img/'.Ets::get('photo')); ?>" alt="{{Ets::get('nom')}}"/>
                            <?php else: ?>
                            <?php endif; ?>
                                <h4 style="margin-top: 0;">{{Ets::get('nom')}}</h4>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <table>
                                <tr>
                                    <td>
                                        <h4 class="pull-right" style="margin: 5px; text-align: right;">Bonjour, <?php echo CurrentUser::get('identifiant'); ?> <br/>
                                            <span class="label label-info">Administrateur</span>
                                        </h4>
                                    </td>
                                    <td>
                                        <?php if( CurrentUser::get('photo') ): ?>
                                            <img style="height: 45px; float: right;" src="<?php echo url('assets/img/students/'.CurrentUser::get('photo')); ?>" alt="<?php echo CurrentUser::get('nom'); ?>"/>
                                        <?php else: ?>
                                            <img style="height: 45px; float: right;" src="<?php echo url('assets/img/students/avartarB.jpg'); ?>" alt="<?php echo CurrentUser::get('nom'); ?>"/>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <form role="form">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Rechercher un élève">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="submit" class="btn btn-default">
                                            <i class="icon icon-ok"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>

    <div id="deuxieme_menu" style="z-index: 1000 !important;" class="container">
        <div class="row affix-row">
            <div class="col-sm-3 col-md-2 affix-sidebar">
                <div class="sidebar-nav">
                    <div class="navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <button style="width: 80px;" type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                                <span class="sr-only" style="margin-right: 5px;">MENU</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse sidebar-navbar-collapse">
                            <ul class="nav navbar-nav" id="sidenav01">
                                <?php if( CurrentUser::is_admin() ): ?>
                                <li>
                                    <a href="<?php echo url('admin'); ?>">
                                        <i class="icon icon-desktop"></i> Tableau de bord
                                    </a>
                                </li>
                                <?php endif; ?>

                                <li>
                                    <a href="<?php echo url('student/list'); ?>"><i class="icon icon-user"></i>
                                        Liste des élèves
                                    </a>
                                </li>
                                <li>
                                    <a  href="<?php echo url('classroom/list'); ?>">
                                        <i class="icon icon-home"></i> Salles de classe
                                    </a>
                                </li>

                                <?php if( CurrentUser::is_admin() ): ?>
                                    <li>
                                        <a  href="<?php echo url('periode/list'); ?>">
                                            <i class="icon icon-exchange"></i> Gestion des sessions
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo url('user/list'); ?>">
                                            <i class="icon icon-group"></i> Utilisateurs
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <a href="<?php echo url('user/add/'.CurrentUser::get('id')); ?>" >
                                        <i class="icon icon-user-md"></i> Mon profile
                                    </a>
                                </li>

                                <?php if( CurrentUser::is_admin() ): ?>
                                    <li>
                                        <a href="{{url('admin/settings')}}">
                                            <i class="icon icon-cog"></i> Réglages
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <a href="<?php echo url('home/logout'); ?>">
                                        <i class="icon icon-signout"></i> Déconnexion
                                    </a>
                                </li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="z-index: 100 !important;">
        <div class="row">
            <div id="menu_principal" class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <div class="panel">
                    <?php if( CurrentUser::is_admin() ): ?>
                    <p>
                        <a data-toggle="tooltip" data-placement="left" title="Tableau de bord" class="btn btn-block btn-default btn-bender" href="<?php echo url('admin'); ?>" style="background-color: #ffffff; border: solid 1px #808080; color: #000000;">
                            <i class="icon icon-desktop icon-2x"></i>
                        </a>
                    </p>
                    <hr style="margin-top: 3px; margin-bottom: 10px; border: solid 1px #2f2f2f;" />
                    <?php endif; ?>
                    <p>
                        <a data-toggle="tooltip" data-placement="left" title="Elèves" class="btn btn-block btn-success btn-bender" href="<?php echo url('student/list'); ?>"><i class="icon icon-user icon-2x"></i></a>
                    </p>

                    <?php if( CurrentUser::is_admin() ): ?>
                    <p>
                        <a data-toggle="tooltip" data-placement="left" title="Classes" class="btn btn-block btn-info btn-bender" href="<?php echo url('classroom/list'); ?>">
                            <i class="icon icon-home icon-2x"></i>
                        </a>
                    </p>

                    <p>
                        <a data-toggle="tooltip" data-placement="left" title="Sessions" class="btn btn-block btn-default btn-bender" href="<?php echo url('periode/list'); ?>" style="background-color: darkorange; border: solid 1px darkorange;">
                            <i class="icon icon-exchange icon-2x"></i>
                        </a>
                    </p>
                    <hr style="margin-top: 3px; margin-bottom: 10px; border: solid 1px #2f2f2f;" />
                    <p>
                        <a data-toggle="tooltip" data-placement="left" title="Utilisateurs" class="btn btn-block btn-default btn-bender" href="<?php echo url('user/list'); ?>" style="background-color: purple; border: solid 1px purple;">
                            <i class="icon icon-group icon-2x"></i></a>
                    </p>
                    <?php endif; ?>

                    <p>
                        <a data-toggle="tooltip" data-placement="left" title="Votre profile" class="btn btn-block btn btn-info btn-bender" href="<?php echo url('user/add/'.CurrentUser::get('id')); ?>" style="background-color: #797979; border: solid 1px #797979;" >
                            <i class="icon icon-user-md icon-2x"></i></a>
                    </p>

                    <?php if( CurrentUser::is_admin() ): ?>
                    <p>
                        <a data-toggle="tooltip" data-placement="left" title="Réglages" class="btn btn-block btn-default btn-bender" href="{{url('admin/settings')}}"><i class="icon icon-cog icon-2x"></i></a>
                    </p>
                    <?php endif; ?>

                    <hr style="margin-top: 3px; margin-bottom: 10px; border: solid 1px #2f2f2f;" />
                    <p>
                        <a data-toggle="tooltip" data-placement="left" title="Quitter" class="btn btn-block btn btn-danger btn-bender" href="<?php echo url('home/logout'); ?>"><i class="icon icon-signout icon-2x"></i></a>
                    </p>
                    <script type="text/javascript">
                        $('.btn-bender').tooltip();
                    </script>
                </div>
            </div>

            <div class="col-lg-10 col-md-2 col-sm-10 col-xs-10">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

  </body>
</html>