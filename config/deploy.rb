# config valid only for Capistrano 3.1
# require 'capistrano/ext/multistage'
lock '3.5.0'

set :stages, ["production","staging"]
set :default_stage, "staging"
set :ssh_options, {:forward_agent => true}

set :application, 'cms'
set :repo_url, 'git@github.com:lukasoppermann/formandsystem-cms.git'
set :user, "lukasoppermann"

set :format_options, log_file: "storage/logs/capistrano.log"
set :default_env, { path: "/usr/local/bin:$PATH" }

#set :linked_dirs, %w()

namespace :deploy do


    desc 'Setup release & Composer install'
    task :composer_install do
        on roles(:app), in: :groups, limit:1 do
            execute "chmod -R 755 #{fetch(:deploy_to)}/releases/#{fetch(:release_timestamp)}/storage"
            execute "chown -R www-data #{fetch(:deploy_to)}/releases/#{fetch(:release_timestamp)}/storage"
            execute "cp #{fetch(:deploy_to)}/shared/.env #{fetch(:deploy_to)}/releases/#{fetch(:release_timestamp)}/.env"
            execute "cd #{fetch(:deploy_to)} && ln -sfn ./releases/#{fetch(:release_timestamp)} ./latest"
            if fetch(:run_composer) == 'true'
                execute "cd #{fetch(:deploy_to)}/latest && composer install --no-dev --no-interaction"
            end
            execute "docker exec cms_php php /var/cachetool.phar opcache:reset --fcgi=#{fetch(:fcgi)} >/dev/null"
            execute "docker exec cms_php php /var/www/html/latest/artisan cache:clear >/dev/null"
        end
    end

end

after "deploy:updated", "deploy:composer_install"
