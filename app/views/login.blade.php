<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Ets::get('nom'); ?></title>

    <link rel="stylesheet" type="text/css" href="<?php echo asset('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <script type="text/javascript" src="<?php echo asset('assets/js/jquery-1.10.2.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('assets/bootstrap/js/bootstrap,min.js'); ?>"></script>
    <style>
        body {
            background-image: url("<?php echo asset('assets/img/login-bg.jpg'); ?>");
            background-repeat: no-repeat;
            background-size: 100%;
        }
        
        #loginkey {
            height: 500px;
            background-image: url("<?php echo asset('assets/img/loginkey.png'); ?>");
            background-repeat: no-repeat;
        }

        div.row {
            min-height: 500px;
            margin-top: 80px;
        }
        
        div.col-lg-4 h3 {
            color: #f2eaf2;
            font-size: 32px;
        }
        
        .panel{
            opacity: 0.9;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="row">
        
            <div class="col-lg-6 col-lg-offset-3">
                <h3 style="color: white;">EDUC</h3>
                <div class="panel">
                    <h3>Espace Direction</h3>
                    <hr>
                    <?php if(Session::has('msg')): ?>
                        <div class="alert">{{Session::get('msg')}}</div>
                    <?php endif; ?>

                    <?php echo Form::open(array('url'=>'home/login')); ?>
                    <?php echo Form::token(); ?>

                	<div class="form-group">
                    <?php echo Form::label('identifiant','Votre identifiant'); ?>
                    <?php echo Form::text('identifiant',Input::old('identifiant'),array('class'=>'form-control','placeholder'=>'Identifiant')); ?>
                    </div>
                    <?php echo $errors->first('identifiant','<div class="alert">Vous devez renseigner votre identifiant</div>'); ?>

                    <div class="form-group">
                    <?php echo Form::label('mdp','Votre mot de passe'); ?>
                    <?php echo Form::password('mdp',array('class'=>'form-control','placeholder'=>'Mot de passe')); ?>
                    <?php echo $errors->first('mdp','<div class="alert">Vous devez renseigner le mot de passe</div>'); ?>
                    </div>
                    <br>

                    <?php echo Form::submit('Me connecter',array('class'=>'btn')); ?>
                    <?php echo Form::close(); ?>
                </div>
            </div>            
        </div>
    </div>
</body>
</html>