set :deploy_to, "~/apps/#{fetch(:application)}"
set :branch, 'v2.0'
set :fcgi, 'cms_php:9000'
set :run_composer, 'true'

server '139.59.156.243', user: 'root', roles: %w{web app db}
