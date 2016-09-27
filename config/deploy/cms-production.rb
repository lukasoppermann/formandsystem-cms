set :deploy_to, "~/#{fetch(:application)}"
set :branch, 'v2.0'

server '138.68.67.85', user: 'root', roles: %w{web app db}
