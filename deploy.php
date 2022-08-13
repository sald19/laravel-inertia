<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:sald19/laravel-inertia.git');
set('update_code_strategy', 'archive');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('laravel-inertia')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/apps');

// Hooks

after('deploy:failed', 'deploy:unlock');