#!/bin/bash

version="$(echo "cat /module/version/text()" | xmllint --nocdata --shell ./config.xml | sed '1d;$d')"
printf '%s\n' "$version"

exit 0
