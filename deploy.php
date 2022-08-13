<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', '');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('157.245.255.11')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/apps');

// Hooks

after('deploy:failed', 'deploy:unlock');
