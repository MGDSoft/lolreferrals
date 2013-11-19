set :stages,        %w(production staging)
set :default_stage, "staging"
set :stage_dir,     "app/config/deploy"

require 'capistrano/ext/multistage'