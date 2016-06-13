############################################
# Setup Server
############################################

set :stage, :staging
set :stage_url, "http://staging.friendsschoolatlanta.org"
server "67.227.201.200", user: "friendsschoolatb", roles: %w{web app db}
set :deploy_to, "/home/friendsschoolatb/public_html/staging"

############################################
# Setup Git
############################################

set :branch, "development"

############################################
# Extra Settings
############################################

#specify extra ssh options:
SSHKit.config.command_map[:git] = '/usr/local/cpanel/3rdparty/bin/git'
#SSHKit.config.command_map[:wp] = '/home/friendsschoolatb/wp-cli.phar'
#SSHKit.config.command_map[:db] = '/home/friendsschoolatb/wp-cli.phar'
SSHKit.config.command_map[:wp] = '/home/friendsschoolatb/bin/wp-cli.phar'
SSHKit.config.command_map[:db] = '/home/friendsschoolatb/bin/wp-cli.phar'

#SSHKit.config.command_map[:db] = '/usr/local/bin/wp'
#SSHKit.config.command_map[:wp] = "php-cli /home/friendsschoolatb/bin/wp-cli.phar"

SSHKit.config.command_map[:find] = '/bin/find'

#set :ssh_options, {
#    auth_methods: %w(password),
#    password: 'password',
#    user: 'username',
#}

#specify a specific temp dir if user is jailed to home
set :tmp_dir, "/home/friendsschoolatb/staging_deploy_tmp"
