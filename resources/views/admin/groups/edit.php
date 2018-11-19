<?php

$view->layout('@admin/admin/layout-bs4.php');
$wei->page->addPluginAssets($app->isAdmin() ? 'admin2' : 'app');
