# InventoryBRM
[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)
### Tech

InvetoryBRM uses a number of open source projects to work properly:
* [Symfony] - Php famework
* [MySql] - Database engine 
* [Nginx] - Environment
* [Docker] - Containers

And of course InventoryBRM itself is open source with a [public repository][dill]
 on GitHub.

### Installation

Requires:
 - [git-cli installation manual](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git/)
 - [docker-compose installation manual](https://docs.docker.com/compose/install/)

Install the dependencies and devDependencies and start the server.

```sh
$ git clone git@github.com:Dante0432/InvetoryBRM.git
$ cd InvetoryBRM
$ docker-compose up -d
# This will take a few minutes until the database filesystem has been generated. 
```
* After verifying that the application is running on [Localhost](http://localhost/) 
```sh
# enter the php bash to access the symfony client
$ docker-compose exec php bash
# In the php bash execute for type autogenerate:
$ bin/console doctrine:migrations:migrate
```

### In the app

 - Register in the login section as an administrator. 
 - Create or edit products.
 - Cancel sale.
 - Invoice pdf generate
 - Register in the login section as a client. 
 - Buy products products.

**Free Software, Hell Yeah!**

   [dill]: <https://github.com/Dante0432/InvetoryBRM>
   [Nginx]: <https://www.nginx.com/>
   [Mysql]: <https://www.mysql.com/>
   [Symfony]: <https://symfony.com/>
   [Docker]: <https://www.docker.com/>
