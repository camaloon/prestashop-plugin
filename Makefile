BIN_DIR=./bin
BUILD_FOLDER_NAME = camaloon
BUILD_DIR=./$(BUILD_FOLDER_NAME)
ARTIFACT_NAME = camaloon
ARTIFACT_PATH = ./$(ARTIFACT_NAME).zip
ENV := staging

ifeq ($(ENV), production)
 HOST = "https:\\/\\/camaloon\\.com"
else
 ifeq ($(ENV), staging)
  HOST = "https:\\/\\/staging1\\.camaloon\\.com"
 else
  $(error Bad env variable. Please use production or staging)
 endif
endif

default: prepare

clean:
	rm -Rf $(BUILD_FOLDER_NAME) $(ARTIFACT_PATH)

prepare:
	mkdir -p ${BUILD_DIR}
	mkdir -p ${BUILD_DIR}/controllers
	mkdir -p ${BUILD_DIR}/sql
	mkdir -p ${BUILD_DIR}/src
	mkdir -p ${BUILD_DIR}/translations
	mkdir -p ${BUILD_DIR}/upgrade
	mkdir -p ${BUILD_DIR}/views
	mkdir -p ${BUILD_DIR}/vendor
	rsync -rav --progress ./controllers ${BUILD_DIR}
	rsync -rav --progress ./sql ${BUILD_DIR}
	rsync -rav --progress ./src ${BUILD_DIR}
	rsync -rav --progress ./translations ${BUILD_DIR}
	rsync -rav --progress ./upgrade ${BUILD_DIR}
	rsync -rav --progress ./views ${BUILD_DIR}
	rsync -rav --progress ./vendor ${BUILD_DIR}
	cp ./camaloon.php ${BUILD_DIR}/camaloon.php
	cp ./composer.json ${BUILD_DIR}/composer.json
	cp ./config.xml ${BUILD_DIR}/config.xml
	cp ./index.php ${BUILD_DIR}/index.php
	cp ./logo.png ${BUILD_DIR}/logo.png
	cp ./Readme.md ${BUILD_DIR}/Readme.md

build:
	composer dump-autoload
	make prepare
	find $(BUILD_DIR) -type f -name "*.php" -exec sed -i '' -e "s/https:\\/\\/dev\\.camaloon\\.com/$(HOST)/g" {} \;
	zip -r $(ARTIFACT_PATH) $(BUILD_DIR)
	rm -Rf $(BUILD_FOLDER_NAME)

version:
	@echo `$(BIN_DIR)/version.sh`
