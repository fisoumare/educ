
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){echo  $title;}else{echo 'EcoGes';}?></title> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

      <meta name="keywords" content="<?php if(!empty($keywords)){echo $keywords;} ?>">
    <meta name="description" content="<?php if(!empty($description)){echo $description;} ?>">

      <!--Chargement des liens css--> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap/css/font-awesome.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap/css/datepicker.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap/css/bootstrap-fileupload.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap/tablecloth/css/tablecloth.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap/tablecloth/css/prettify.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo css_url('style'); ?>">  
    <?php
        /*Cette condition verifie si depuis le controleur des liens javascript ont ete specifies, si oui il les affiche*/
        if(isset($css_link_list))
        {
            foreach($css_link_list as $css_link)
            {
            ?>
            <link type="text/css" rel="stylesheet" href="<?php echo css_url($css_link); ?>" media="screen" />
            <?php
            }
        }
    ?>
 
    <!--Importation de la bibliothe jquery-->
    <script type="text/javascript" src="<?php echo js_url('jquery-1.7.2.min');?>"></script> 
    <!--Chargement des autres liens javascript-->
    <script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js' ?> "></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap-datepicker.js' ?> "></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/js/bootstrap-fileupload.js' ?> "></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/tablecloth/js/jquery.metadata.js' ?> "></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/tablecloth/js/jquery.tablesorter.min.js' ?> "></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/bootstrap/tablecloth/js/jquery.tablecloth.js' ?> "></script>
    
    <!--Chargement des autres liens javascript-->
    <?php
        /*Cette condition verifie si depuis le controleur des liens javascript ont ete specifies, si oui il les affiche*/
        if(isset($js_link_list))
        {
            foreach($js_link_list as $js_link)
            {
            ?>
            <script type="text/javascript" src="<?php echo js_url($js_link); ?>"></script>
            <?php
            }
        }
    ?>
    
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
</head>
<body>
    
<?php $this->load->view('commun/menu_principal'); ?>

<div class="container conteneur_principal">