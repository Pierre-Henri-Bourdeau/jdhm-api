
JDHM-Api
========
[![Build Status](https://travis-ci.org/bourdeau/jdhm-api.svg?branch=master)](https://travis-ci.org/bourdeau/jdhm-api) [![Stories in Ready](https://badge.waffle.io/bourdeau/jdhm-api.svg?label=ready&title=Ready)](http://waffle.io/bourdeau/jdhm-api) [![Dependency Status](https://www.versioneye.com/user/projects/56ae02f37e03c700377e0056/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56ae02f37e03c700377e0056) [![Code Climate](https://codeclimate.com/github/bourdeau/jdhm-api/badges/gpa.svg?style=flat)](https://codeclimate.com/github/bourdeau/jdhm-api) [![Test Coverage](https://codeclimate.com/github/bourdeau/jdhm-api/badges/coverage.svg?style=flat)](https://codeclimate.com/github/bourdeau/jdhm-api/coverage) [![Issue Count](https://codeclimate.com/github/bourdeau/jdhm-api/badges/issue_count.svg?style=flat)](https://codeclimate.com/github/bourdeau/jdhm-api) [![Gitter](https://badges.gitter.im/bourdeau/jdhm-api.svg?style=flat)](https://gitter.im/bourdeau/jdhm-api?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
[![Throughput Graph](https://graphs.waffle.io/bourdeau/jdhm-api/throughput.svg)](https://waffle.io/bourdeau/jdhm-api/metrics)

Jdhm-Api is a private RESTful API

## Installation

### Install Environment

##### PHP7

```
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php7.0 php7.0-dev php7.0-cli php7.0-curl php7.0-dev php7.0-intl php7.0-json php7.0-mysql php7.0-opcache php7.0-readline php7.0-curl

# Check version
php -v
```

##### Xdebug

```
git clone git://github.com/xdebug/xdebug.git && cd xdebug
phpize
./configure --enable-xdebug
make
make test
sudo make install

# Add to /etc/php/7.0/apache2/php.ini &&
zend_extension="/usr/lib/php/20151012/xdebug.so"
```

##### Composer

```
curl -sS https://getcomposer.org/installer | php && mv composer.phar ~/bin/composer && chmod +x ~/bin/composer
```

##### Travis CLI

```
sudo gem install travis

travis login

travis encrypt CODECLIMATE_REPO_TOKEN=super_secret --add env.global
```

Then you can use it like this:

```
${CODECLIMATE_REPO_TOKEN}
```

Read this for help: https://docs.travis-ci.com/user/environment-variables/

### Install Project

##### Clone & install vendors
``` bash
git clone git@github.com:Pierre-Henri-Bourdeau/jdhm-api.git && cd jdhm-api && composer install --prefer-dist
```

##### Folders permission
``` bash

HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs

```

## Server deploy

``` bash
sudo visudo
# Allow ph for Capifony deploy
ph ALL=(ALL) NOPASSWD:ALL
```
