<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-pills">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Blog</a></li>
                <?php if(Session::has('user_id')): ?>
                    <li><a href="<?php echo url('home/logout'); ?>">Deconnexion</a></li>
                <?php else: ?>
                    <li><a href="<?php echo url('home/inscription'); ?>">Inscription</a></li>
                    <i><a href="<?php echo url('home/login'); ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>