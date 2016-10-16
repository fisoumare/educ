<div class="container" id="menu_princpal">
    <div class="row">
        <div class="span12">
            <div class="navbar">
                <div class="navbar-inner" style="width: 100%;">
                    <ul class="nav nav-pills navbar-fixed-top"  style="padding: 0 20px 0 20px;">
                      <li>
                        <a href="<?php echo site_url('ecoges'); ?>">Tableau de bord</a>
					  </li>
                      <li class="dropdown">
					  		<a href="<?php echo site_url('etablissement'); ?>" class="dropdown-toggle" data-toggle="dropdown">
							Mon Etablissement <b class="caret"></b></a>
					  		<ul class="dropdown-menu">
								<li><a href="<?php echo site_url('ets_session/liste_session'); ?>">Sessions</a></li>
								<hr class="divider" />
								<li><a href="<?php echo site_url('ets_faculte/liste_faculte'); ?>">Facultés</a></li>
								<li><a href="<?php echo site_url('ets_departement/liste_departement'); ?>">Départements</a></li>
								<li><a href="<?php echo site_url('ets_classe/liste_classe'); ?>">Classes</a></li>
								<hr class="divider" />
								<li><a href="<?php echo site_url('ets_enseignant/liste_enseignant'); ?>">Enseignants</a></li>
								<hr class="divider" />
								<li><a href="<?php echo site_url('ets_matiere/liste_matiere'); ?>">Matières</a></li>
								<hr class="divider" />
								<li><a href="<?php echo site_url('ets_matiere/liste_matiere'); ?>">Examens & Evaluation</a></li>
							</ul>
					  </li>
                      <li class="dropdown">
                          <a href="<?php echo site_url('etudiant/liste'); ?>" class="dropdown-toggle" data-toggle="dropdown">
						  Etudiants <b class="caret"></b></a>
                          <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('ets_etudiant/ajouter'); ?>">Ajouter un étudiant</a></li>    
                            <li><a href="<?php echo site_url('ets_etudiant/liste'); ?>">Liste des étudiants</a></li>    
                          </ul>
                      </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>