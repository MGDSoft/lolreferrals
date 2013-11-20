set :stages,        %w(pre pro stag)
set :default_stage, "staging"
set :stage_dir,     "app/config/deploy"

require 'capistrano/ext/multistage'