# Camaloon Print on Demand

## Release

To generate a release zip run:

Give permissions to the release script
```bash
chmod +x release.sh
```

Generate the release zip file

```bash
./release.sh
```

## Development environment

### Setup
- copy the .env.example to .env
- add a file composer.json and add this content:
  {
      "name": "name/prestashop-plugin",
      "description": "<module description>",
      "authors": [
          {
              "name": "name/prestashop-plugin",
              "email": "email"
          }
      ],
      "require": {
          "php": ">=5.6.0"
      },
      "autoload": {
          "psr-4": {
              "<YourNamespace>\\": "src/"
          },
          "classmap": [
              "camaloon.php"
          ],
          "exclude-from-classmap": []
      },
      "config": {
          "preferred-install": "dist",
          "prepend-autoloader": false
      },
      "type": "prestashop-module",
      "author": "name",
      "license": "Camaloon"
  }

 Replace name by your name and email by your email.

- run composer dump-autoload (you should see Generated autoload files)
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
