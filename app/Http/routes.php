<?php

App::setLocale('en'); 

require __DIR__.'/Routes/api.php';
require __DIR__.'/Routes/api-admin.php';
require __DIR__.'/Routes/api-user.php';
require __DIR__.'/Routes/api-game.php';
require __DIR__.'/Routes/api-cron.php';

//page api come later
require __DIR__.'/Routes/page.php';
require __DIR__.'/Routes/page-user.php';
require __DIR__.'/Routes/page-admin.php';
require __DIR__.'/Routes/page-docs.php';
require __DIR__.'/Routes/page-edm.php';