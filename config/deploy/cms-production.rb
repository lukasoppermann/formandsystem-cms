set :deploy_to, "~/#{fetch(:application)}"

server '46.101.122.242', user: 'root', roles: %w{web app db}
