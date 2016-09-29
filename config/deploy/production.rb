set :deploy_to, "~/#{fetch(:application)}"
set :branch, 'v2.0'

server '139.59.156.243', user: 'root', roles: %w{web app db}
