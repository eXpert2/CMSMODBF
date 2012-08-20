<?php /* Smarty version Smarty-3.1.7, created on 2012-08-20 23:52:40
         compiled from "db:menu" */ ?>
<?php /*%%SmartyHeaderCode:12371503255d818a9f7-69850025%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57182cbcc802609b68de30d5f26e5ec37d6ef11f' => 
    array (
      0 => 'db:menu',
      1 => 1345488759,
      2 => 'db',
    ),
  ),
  'nocache_hash' => '12371503255d818a9f7-69850025',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_503255d818fb1',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_503255d818fb1')) {function content_503255d818fb1($_smarty_tpl) {?><h1>Sidebar</h1>
<h2><a href="/">Главная</a></h2>
<p>Статичная страница, где только текст.</p>
<h2><a href="/page/about">О нас</a></h2>
<p>Статичная страница, где только текст и контактные данные.</p>
<h2><a href="/page/news">Новости</a></h2>
<p>Пример списка информационных блоков с постраничной навигацией.</p>
<h2><a href="/page/static_catalog">Плакаты</a></h2>
<p>Каталог статичный, только плакаты.</p>
<h2><a href="/page/recursive_catalog">Рекурсивный каталог</a></h2>
<p>Каталог рекурсивный, выведены все товары из подкаталогов.</p>
<h2><a href="/page/nonrecursive_catalog">Не рекурсивный каталог</a></h2>
<p>Каталог динамически, выводятся по запросу url, без товаров подкаталогов.</p><?php }} ?>