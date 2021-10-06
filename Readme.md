# Camaloon Print on Demand

## Development environment

### Setup
- copy the .env.example to .env
- run `docker-compose up`
- go to admin part, by defult (`http://localhost:8083/adminPS`)
- login to admin part (default credentials `demo@prestashop.com` / `prestashop_demo`)
- go to: Modules > Module Catalog
- search for Camaloon module and activate it

### Notes

Dev environment is powered by Docker, based on official images: https://hub.docker.com/r/prestashop/prestashop/
Important thing is `.env` file to setup project, you can check all things that can be altered on Docker Hub.

## Installation for remote server
- login to admin part ( [prestashop_domain]/adminPS )
- go to: Modules > Module Manager
- upload Module

### Notes
- the archive should have folder plugin on top level
- the folder name should match plugin name
- we cannot put plugin files to the top level
