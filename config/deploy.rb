# config valid only for Capistrano 3.1
# require 'capistrano/ext/multistage'
lock '3.5.0'

set :stages, ["production"]
set :default_stage, "production"
set :ssh_options, {:forward_agent => true}

set :application, 'formandsystem_cms'
set :repo_url, 'git@github.com:lukasoppermann/formandsystem-cms.git'
set :user, "lukasoppermann"

# set :linked_dirs, %w()

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
        #within release_path do
            # execute :composer, "install" # install dependencies
            run "php composer.phar install --working-dir #{fetch(:latest_release_directory)}"
        #end
      end
    end

end

after "deploy:updated", "deploy:composer_install"
