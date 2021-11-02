# this is a makefile to speed up the process of publishing through svn for WP plugin
# usage:
# make prepare -> setups the project to upload
FOLDER="camaloon"

default: prepare

prepare:
	mkdir -p ${FOLDER}
	mkdir -p ${FOLDER}/controllers;cp -R controllers ${FOLDER}
	mkdir -p ${FOLDER}/sql;cp -R sql ${FOLDER}
	mkdir -p ${FOLDER}/src;cp -R src ${FOLDER}
	mkdir -p ${FOLDER}/translations;cp -R translations ${FOLDER}
	mkdir -p ${FOLDER}/upgrade;cp -R upgrade ${FOLDER}
	mkdir -p ${FOLDER}/vendor;cp -R vendor ${FOLDER}
	mkdir -p ${FOLDER}/views;cp -R views ${FOLDER};rm ${FOLDER}/views/.DS_Store
	mkdir -p ${FOLDER}/vendor;cp -R vendor ${FOLDER}
	cp camaloon.php ${FOLDER}/camaloon.php
	cp composer.json ${FOLDER}/composer.json
	cp config.xml ${FOLDER}/config.xml
	cp index.php ${FOLDER}/index.php
	cp logo.png ${FOLDER}/logo.png
	cp README.md ${FOLDER}/README.md

clean:
	rm -rf ${FOLDER}
