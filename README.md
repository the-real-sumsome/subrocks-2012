# subrocks-2012
a 2012 rewrite for subrocks

# THE SITE IS CURRENTLY ON HIATUS BECAUSE OF SCHOOL, CODE REWRITE WILL BE WITHIN 1 WEEK

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/the-real-sumsome/subrocks-2012/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/the-real-sumsome/subrocks-2012/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/the-real-sumsome/subrocks-2012/badges/build.png?b=main)](https://scrutinizer-ci.com/g/the-real-sumsome/subrocks-2012/build-status/main)

SubRocks is a faithful recreation & reverse engineering effort for 2012 YouTube. You can visit the site at https://subrock.rocks.

![SubRocks 2012 Homepage](https://i.imgur.com/fenftoY.png)

## Requirements
- Docker
- Linux (Recommended)
- A functioning brain
- Blood vessels

## How to setup
Run `docker-compose up -d` inside the root of this repository.

Wait for it to compile everything, then go to http://localhost:8080.

The default username & password is root. Host is `mysql`. 

Import the SQL file in `sql_setup` and you are basically finished with the setup.

## Important Information
- Web server: localhost:8000
- PHPMyAdmin: localhost:8080
  - username: root
  - password: root
  - host:     (none, or you can put mysql)

## Things that you should expect soon:
- ~~Dockerized~~
- Templating
- Router
- Translations
