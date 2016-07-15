set :deploy_to, "/fs/cms"

server '185.21.102.106', user: 'ssh-373917-veare', roles: %w{web app db}
