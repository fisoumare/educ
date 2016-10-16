<?php if(count($liste_student) > 0): ?>

    <?php //Si l'url est celui qui convertit en pdf, alors on affiche pas les photos
    if( Request::segment('2') == 'list-to-pdf' ): ?>
        <h2 style="margin-top: 0; color: #30898c;"><?php echo Ets::get('nom'); ?></h2>
        <p><?php echo Ets::get('adresse').' | '.Ets::get('tel').' | '.Ets::get('email'); ?></p>
        <hr style="margin: 5px 0 5px 0;"/>
        <h3>Liste des élèves
            <?php
                if(Session::has('rechercheEleve.filtre_scolarite')){
                    echo ' non en règle sur les frais de scolarité <br> ';
                }

                echo '( '.count($liste_student);
                if(Session::has('rechercheEleve.periode')){
                    echo ' | Session : '.Periode::find(Session::get('rechercheEleve.periode'))->interval;
                }

                if(Session::has('rechercheEleve.category')){
                    echo ' | Catégorie : '.Category::find(Session::get('rechercheEleve.category'))->nom;
                }

                if(Session::has('rechercheEleve.classroom')){
                    echo ' | Classe : '.Classroom::find(Session::get('rechercheEleve.classroom'))->nom;
                }
                echo ' )';
            ?>
        </h3>
    <?php endif; ?>

    <?php //Si l'url est celui qui convertit en pdf
    if( Request::segment('2') == 'list-to-pdf' ): ?>
    <table class="table table-responsive" style="width: 100%;">
    <?php else: ?>
    <table class="table table-responsive table-striped table-hover table-condensed" style="width: 100%;">
    <?php endif; ?>
        <tr style="font-weight: bold;">
            <td>#</td>
            <?php //Si l'url est celui qui convertit en pdf, alors on affiche pas les photos
            if( Request::segment('2') != 'list-to-pdf' ): ?>
                <td>
                </td>
            <?php endif; ?>
            <td>Nom</td>
            <td>Prénom</td>
            <td>Date de naissance</td>
            <td>
                Classe
            </td>
            <td>Sexe</td>
            <?php //Si l'url est celui qui convertit en pdf, alors on affiche pas les boutons
            if( Request::segment('2') != 'list-to-pdf' ): ?>
                <td>
                </td>
            <?php endif; ?>
        </tr>
        <?php $i = 1; foreach($liste_student as $eleve): ?>
            <tr>
                <td>{{$i}}</td>

                <?php //Si l'url est celui qui convertit en pdf, alors on affiche pas les photos
                if( Request::segment('2') != 'list-to-pdf' ): ?>
                <td>
                    <?php if(!empty($eleve->photo)): ?>
                        <img class="img-circle" style="height: 30px;" src="<?php echo url('assets/img/students/'.$eleve->photo); ?>" alt="<?php echo $eleve->nom; ?>"/>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <?php endif; ?>

                <td>{{$eleve->nom}}</td>
                <td>{{$eleve->prenom}}</td>
                <td>{{$eleve->date_naissance}}</td>
                <td>
                    <?php if( Session::has('rechercheEleve.periode') ): ?>
                        <?php $classe = Student::getHisClassroom($eleve->id,Session::get('rechercheEleve.periode')); ?>
                        <?php if( $classe != null): ?>
                            <?php echo $classe->nom; ?>
                        <?php else: ?>
                            <a href="<?php echo url('student'); ?>" class="btn btn-link">Inscrire</a>
                        <?php endif; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php
                        if( $eleve->sexe == 'f' ){
                            echo 'Féminin';
                        } else {
                            echo 'Masculin';
                        }
                    ?>
                </td>

                <?php //Si l'url est celui qui convertit en pdf, alors on affiche pas les boutons
                if( Request::segment('2') != 'list-to-pdf' ): ?>
                <td style="min-width: 150px;">
                    <div class="options btn-group pull-right">
                        <a class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> Options</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo url('student/profil/'.$eleve->id); ?>">
                                    <i class="icon-eye-open"></i> Afficher son profil</a>
                            </li>
                            <li>
                                <a href="<?php echo url('student/add/'.$eleve->id); ?>">
                                    <i class="icon-pencil"></i> Editer</a>
                            </li>
                            <hr class="divider">
                            <li>
                                    <a href="<?php echo url((Session::has('rechercheEleve.periode'))?'payment/list/'.$eleve->id.'/'.Session::get('rechercheEleve.periode'):'payment/list/'.$eleve->id); ?>">
                                        <i class="icon-money"></i> Payer la scolarité</a>
                            </li>

                            <?php if( CurrentUser::is_admin() ): ?>
                            <li>
                                <a id="{{$eleve->id}}" class="define_payment" data-toggle="modal" href="#define_payment" lien="<?php echo url('student/define-payment/'.$eleve->id); ?>" lien_periode="<?php echo url('student/get-liste-periode/'.$eleve->id); ?>" >
                                    <i class="icon-money"></i> Définir la scolarité</a>
                            </li>
                            <?php endif; ?>
                            <hr class="divider">
                            <li>
                                <a href="{{url('student/reinscription/'.$eleve->id)}}">
                                    <i class="icon-money"></i> Réinscrire pour Session</a>
                            </li>
                            <li>
                                <a class="desinscription" data-toggle="modal" href="#desinscription" lien="{{url('student/desinscription/'.$eleve->id)}}" lien_periode="{{url('student/get-liste-periode/'.$eleve->id)}}">
                                    <i class="icon-money"></i> Désinscrire d'une Session</a>
                            </li>

                            <?php if( CurrentUser::is_admin() ): ?>
                                <hr class="divider">
                                <li>
                                    <a class="supprimer_eleve" data-toggle="modal" href="#supprimer_user" lien="<?php echo url('student/delete/'.$eleve->id); ?>" >
                                        <i class="icon-trash"></i> Supprimer</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </td>
                <?php endif; ?>
            </tr>
            <?php $i++; endforeach; ?>
    </table>
    <?php //echo $liste_student->links(); ?>
<?php else: ?>
        <div class="alert alert-dismissable alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Aucun élève dans la liste.</strong>
        </div>
<?php endif; ?>
