#!/usr/bin/env bash

zipname="camaloon.zip"

echo "..removing previous $zipname"
rm -f $zipname

echo "..creating zip file at $zipname"
zip -r $zipname * -x Readme.md -x docker-compose.yml -x release.sh -x .env -x .gitignore -x .git

echo "File $zipname generated"

exit 1
