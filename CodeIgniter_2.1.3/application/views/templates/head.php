<head>
	<!-- Acá poner el título, las importaciones de los css y javascript -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/bootstrap.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/bootstrap-fileupload.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/personalizados.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/ant-sig.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/faq.css" type="text/css" media="all" />
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/jquery.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/faq.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-transition.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-alert.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-modal.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-dropdown.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-scrollspy.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-tab.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-tooltip.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-popover.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-button.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-collapse.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-carousel.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-typeahead.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-fileupload.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrapx-clickover.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/ant-sig.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/undo-redo.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/ckeditor/ckeditor.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/ckeditor/config.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/ckeditor/build-config.js"></script>
    <script src="/<?php echo config_item('dir_alias') ?>/ckeditor/styles.js"></script>
    
    <script src="/<?php echo config_item('dir_alias') ?>/javascripts/comunesFiltros.js"></script>
    <script>
    //Configura la apariencia de colores de los botones de la barra lateral
    $(document).ready(function() {
        $('.accordion-group').css("box-shadow", "0px 1px 1px rgba(0, 0, 0, 0) inset, 0px 0px 8px rgba(0, 0, 0, 0)")
        $(".in").parents('.accordion-group').css("box-shadow", "0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(82, 168, 236, 0.6)")

        $(".in").parents('.accordion-group').css("border-radius", "4px")
        $(".in").parents('.accordion-group').css("-moz-border-radius", "4px")
        $(".in").parents('.accordion-group').css("-webkit-border-radius", "4px")
        $('.accordion-heading').css("border-radius", "5px")
        $('.accordion-heading').css("background-color", "rgb(255, 255, 255)")
        $(".in").parents('.accordion-group').find('.accordion-heading').css("background-color", "rgb(248, 248, 248)")
        $(function() { 
            $('[rel="clickover"]').clickover(); 
        });
    
    });
    </script>
</head>
