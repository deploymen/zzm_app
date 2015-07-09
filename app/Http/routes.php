<?php

App::setLocale('en'); 

require __DIR__.'/Routes/1.0/api.php';
require __DIR__.'/Routes/1.0/api-admin.php';
require __DIR__.'/Routes/1.0/api-user.php';
require __DIR__.'/Routes/1.0/api-game.php';
require __DIR__.'/Routes/1.0/api-cron.php';

//page api come later
require __DIR__.'/Routes/1.0/page.php';
require __DIR__.'/Routes/1.0/page-user.php';
require __DIR__.'/Routes/1.0/page-admin.php';
require __DIR__.'/Routes/1.0/page-docs.php';
require __DIR__.'/Routes/1.0/page-edm.php';
require __DIR__.'/Routes/1.0/page-member.php';
require __DIR__.'/Routes/1.0/page-public.php';
