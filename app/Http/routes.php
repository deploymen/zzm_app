<?php

App::setLocale('en'); 

require __DIR__.'/Routes/1.0/api.php';
require __DIR__.'/Routes/1.0/api-admin.php';
require __DIR__.'/Routes/1.0/api-user.php';
require __DIR__.'/Routes/1.0/api-game.php';
require __DIR__.'/Routes/1.0/api-cron.php';

require __DIR__.'/Routes/1.0/page-docs.php';

require __DIR__.'/Routes/old/api.php';
require __DIR__.'/Routes/old/api-admin.php';
require __DIR__.'/Routes/old/api-user.php';
require __DIR__.'/Routes/old/api-game.php';
