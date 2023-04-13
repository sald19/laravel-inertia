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

    set('remote_user', 'root');

    run('echo $USER');
});

task('hocuspocus:restart', function () {
    $sudo = get('writable_use_sudo') ? 'sudo' : '';

    run("$sudo");
});


after('deploy:shared', 'hocuspocus:install');
after('hocuspocus:install', 'hocuspocus:restart');

// Hooks
after('deploy:failed', 'deploy:unlock');
