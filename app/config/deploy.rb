set :stages,        %w(pre pro)
set :default_stage, "pre"
set :stage_dir,     "app/config/deploy"

require 'capistrano/ext/multistage'