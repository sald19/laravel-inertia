<?php

declare(strict_types=1);

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

task('yarn:build', function () {
    run('cd {{release_path}} && {{bin/yarn}} build');
});

after('deploy:shared', 'yarn:install');
after('yarn:install', 'yarn:build');

task('hocuspocus:install', function () {
    run('cd {{release_path}}/hocuspocus && {{bin/yarn}} install');
});

set('shared_files', ['.env', 'hocuspocus/.env']);

task('prisma:generate', function () {
    run('cd {{release_path}}/hocuspocus && npx prisma generate');
});

task('supervisor:restart', function () {
    run('sudo -s supervisorctl status');
})->desc('Restart supervisord restart');

after('deploy:shared', 'hocuspocus:install');
after('hocuspocus:install', 'prisma:generate');
after('prisma:generate', 'supervisor:restart');

// Hooks
after('deploy:failed', 'deploy:unlock');
