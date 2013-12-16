set :application, "referralslol"
set :domain,      "#{application}.com"
set :deploy_to,   "/var/www/vhosts/#{domain}/httpdocs/deployer"
set :app_path,    "app"
set :user,        "referralslol"
set :use_sudo,    false

set :repository,  "file:///var/www/lol"
set :scm,         :git

# set :deploy_via, :copy
set :deploy_via, :rsync_with_remote_cache

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

set :use_composer, true
set :update_vendrors, true
set :dump_assetic_assets, true

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

set :shared_files,        ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads"]