<?php
    // Setup our default assets to load.
    Assets::add_js( array(
        Template::theme_url('js/jquery.form.js'),
        Template::theme_url('js/ui.js')
    ),
    'external',
    true);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?php echo isset($toolbar_title) ? $toolbar_title .' : ' : ''; ?> <?php echo config_item('site.title') ?></title>
<!--[if lte IE 6]><link href="<?php echo Template::theme_url()?>css/ie6.css" rel="stylesheet" type="text/css" media="screen" /><![endif]-->
<!--[if lte IE 7]><link href="<?php echo Template::theme_url()?>css/ie7.css" rel="stylesheet" type="text/css" media="screen" /><![endif]-->
<link href="<?php echo Template::theme_url()?>screen0.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo Template::theme_url()?>css/screen.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo Template::theme_url()?>css/layouts.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo Template::theme_url()?>css/buttons.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo Template::theme_url()?>css/ui.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo Template::theme_url()?>css/notifications.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?php echo base_url() .'assets/js/head.min.js' ?>"></script>
<script src="<?php echo base_url() .'assets/js/jquery-1.5.min.js' ?>"></script>
    <script>
    head.feature("placeholder", function() {
        var inputElem = document.createElement('input');
        return new Boolean('placeholder' in inputElem);
    });
    </script>

<style>
.content-main {padding: 5px;}
.content-main h1 {display:block;clear:both; margin: 0;padding:15px;}
.content-main p {clear:both; margin-left: 0; padding-left: 15px;}
.content-main fieldset {border:1px solid #ddd;}



</style>
</head>
<body>

<noscript>
        <p>Javascript is required to use Bonfire's admin.</p>
</noscript>
<div id="message">
        <?php echo Template::message(); ?>
</div>

<div id="container">
<div id="header" >
    <h1 style="line-height: 14px;">CMS Nsign<span> :: Система управления сайтом. (v. CIBF.0.1)</span></h1>
    <div>
        <img id="nsign-header-logo" src="<?php echo Template::theme_url()?>images/nsign-header-logo.gif" width="144" height="57">
        <p id="site-adress"><strong>Сайт: </strong><?php echo config_item('site.title') ?><br><strong>Адрес сайта: </strong><a href="<?php echo base_url();?>"><?php echo base_url();?></a></p>
        <b><p id="site-adress"></b></p>
        <div id="options">
            <ul>
                <li><a href="<?php echo site_url(SITE_AREA .'/settings/users/edit/'. $this->auth->user_id()) ?>" id="tb_email" title="<?php echo lang('bf_user_settings') ?>"><?php echo config_item('auth.use_usernames') ? (config_item('auth.use_usernames') == 2 ? $this->auth->user_name() : $this->auth->username()) : $this->auth->email() ?></a></li>
                <li><a href="<?php echo site_url('logout') ?>" id="tb_logout" title="Logout">Logout</a></li>
            </ul>
            <div id="loader" style="display:none;">
                <div class="box">
                    <img src="<?php echo Template::theme_url()?>images/loader.gif" />
                </div>
            </div>
        </div>
    </div>
    <ul id="nav">
        <?php echo context_nav() ?>
    </ul>

</div> <!-- /header -->


<div id="sidebar">

<div id="menu">
    <?php echo modules::run('subnav/subnav/index', $this->uri->segment(2)); ?>
</div>
<img src="<?php echo Template::theme_url()?>images/emp.gif" height=200 width=1 style="float:left"> <!-- /sidebar -->
</div> <!-- /menu -->

<div id="wrapper" style="margin-left:190px;width:81%;"> <!-- negative margin trick -->
<div id="content_mn" style="margin-left:0px;">

<table style="margin:0;">
<tr><td style="padding:3px;">
            <?php if (isset($toolbar_title)) : ?>
                <h4><?php echo $toolbar_title ?></h4>
            <?php endif; ?>
            </td>
            <td style="padding:3px;">
            <?php Template::block('sub_nav', ''); ?>
</td></tr></table>


<div id="bf_cnt">
    <div class="content-main <?php echo isset(Template::$blocks['nav_bottom']) ? 'with-bottom-bar' : '' ?>">
                <?php echo Template::yield(); ?>
    </div>
</div>


</div> <!-- /content -->
</div> <!-- /wrapper -->
</div> <!-- /container -->
<br style="clear:both">
<div id="footer">
<img id="nsign-footer-logo" src="<?php echo Template::theme_url()?>images/nsign-footer-logo.gif" width="114" height="66">
<p id="services"><a href="http://nsign.ru/">Веб-дизайн</a>, <a href="http://nsign.ru/">разработка сайта</a>,<br><a href="http://nsign.ru/">поддержка и продвижение</a> — <a href="http://nsign.ru/">Nsign</a></p>
<p id="contacts"><a href="http://nsign.ru/">Контактная информация</a><br><a href="http://nsign.ru/">Поддержка системы</a></p>
<p id="telephone"><strong>тел.:</strong> +7(495) 740-43-28<br>+7(495) 998-34-79</p>
</div><!-- /footer -->



    <div id="debug"><!-- Stores the Profiler Results --></div>

    <script>
        head.js(<?php echo Assets::external_js(null, true) ?>);
    </script>
    <?php echo Assets::module_js(); ?>
    <?php echo Assets::inline_js(); ?>

</body>
</html>
