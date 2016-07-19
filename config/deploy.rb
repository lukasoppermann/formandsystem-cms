# config valid only for Capistrano 3.1
# require 'capistrano/ext/multistage'
lock '3.5.0'

set :stages, ["cms-production","cms-staging"]
set :default_stage, "cms-staging"
set :ssh_options, {:forward_agent => true}

set :application, 'formandsystem_cms'
set :repo_url, 'git@github.com:lukasoppermann/formandsystem-cms.git'
set :user, "lukasoppermann"
set :default_env, { path: "/usr/local/bin:$PATH" }

#set :linked_dirs, %w()

namespace :deploy do


    desc 'Print The Server Name'
    task :print_server_name do
      on roles(:app), in: :groups, limit:1 do
        execute "hostname"
      end
    end

    desc 'Composer install'
    task :composer_install do
        on roles(:app), in: :groups, limit:1 do
            execute "cp #{fetch(:deploy_to)}/shared/.env #{fetch(:release_path)}/.env"
            execute "/usr/local/bin/php5-56STABLE-CLI /kunden/373917_13187/composer.phar install --working-dir #{fetch(:release_path)} --no-scripts --no-dev"
            # execute "cd #{fetch(:release_path)} && \Illuminate\\Foundation\\ComposerScripts::postInstall"
            execute "cd #{fetch(:release_path)} && /usr/local/bin/php5-56STABLE-CLI artisan clear-compiled"
            execute "cd #{fetch(:release_path)} && /usr/local/bin/php5-56STABLE-CLI artisan optimize"
        end
    end

end

after "deploy:updated", "deploy:composer_install"
