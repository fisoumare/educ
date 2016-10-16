<hr style="border: dotted 1px #ccc; margin-top: 0; margin-bottom: 5px;">
<div class="row">
    <div class="col-lg-8" id="titre_article">
        @if(isset($user))
            <h3>{{$user->nom}} {{$user->prenom}}</h3>
            <h4><span class="label label-primary">{{ $user->type }}</span></h4>
        @endif

    </div>
    <?php if(CurrentUser::is_admin()): ?>
    <div class="col-lg-4">
        <p class="pull-right">
            <a href="<?php echo url('user/add'); ?>" class="btn btn-small btn-primary">Nouvel utilisateur</a>
            <a href="<?php echo url('user'); ?>" class="btn btn-small btn-default">Liste des utilisateurs</a>
        </p>

    </div>
    <?php endif; ?>
</div>
<hr style="border: dotted 1px #ccc; margin-top: 0; margin-bottom: 5px;">