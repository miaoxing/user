<?php

$view->layout('@admin/admin/layout-v3.php');
$wei->page->addPluginAssets($app->isAdmin() ? 'admin2' : 'app');
