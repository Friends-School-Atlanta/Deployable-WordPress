############################################
# Setup Server
############################################

set :stage, :local
set :stage_url, "http://fsa.dev"
server "192.168.50.4", user: "vagrant", roles: %w{web app db}
set :deploy_to, "/srv/www/fsa/new_htdocs"

############################################
# Setup Git
############################################

set :branch, "development"

############################################
# Extra Settings
############################################

#specify extra ssh options:
SSHKit.config.command_map[:git] = '/usr/bin/git'
SSHKit.config.command_map[:wp] = '/usr/local/bin/wp'
SSHKit.config.command_map[:find] = '/usr/bin/find'

#set :ssh_options, {
#    auth_methods: %w(password),
#    password: 'password',
#    user: 'username',
#}

#specify a specific temp dir if user is jailed to home
# set :tmp_dir, "/home/friendsschoolatb/production_deploy_tmp"
