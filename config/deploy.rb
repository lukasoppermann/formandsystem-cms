# config valid only for Capistrano 3.1
# require 'capistrano/ext/multistage'
lock '3.5.0'

set :stages, ["production"]
set :default_stage, "production"
set :ssh_options, {:forward_agent => true}

set :application, 'formandsystem_cms'
set :repo_url, 'git@github.com:lukasoppermann/formandsystem-cms.git'
set :user, "lukasoppermann"
set :default_env, {
  'PATH' => "$PATH:/usr/local/bin/"
}

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
            execute "/usr/local/bin/php5-56STABLE-CLI /kunden/373917_13187/composer.phar install --working-dir #{fetch(:release_path)}"
            execute "cp #{fetch(:deploy_to)}/shared/.env #{fetch(:release_path)}/.env"
        end
    end

end

after "deploy:updated", "deploy:composer_install"
