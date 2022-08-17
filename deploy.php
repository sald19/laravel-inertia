<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/yarn.php';


// Config

set('repository', 'git@github.com:sald19/laravel-inertia.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('157.245.255.11')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/apps');

task('deploy:install_packages', function () {
    cd('{{release_path}}');
    run('yarn install');
});

task('deploy:build', function () {
    cd('{{release_path}}');
    run('yarn build');
});

after('deploy:update_code', 'yarn:install');
after('deploy:install_packages', 'yarn:install');

// Hooks

after('deploy:failed', 'deploy:unlock');
