## Examiner


### config
All necessary config is in env.example. Just copy env.example to .env

### If serving from vagrant

```
$ vagrant up
```
- for starting up virtual machine

```
$ vagrant ssh
```
- connect to virtual machine via ssh

```
$ vagrant halt
```
- stop the machine


### Setting up this beauty!

```
$ cp .env.example .env
```
- copy .env.example to .env (don't forget to edit this file according to your needs)

```
$ composer install
```
- install all dependencies for laravel and PHP

```
$ php artisan key:generate
```
- generate a new key for your application

```
$ php artisan migrate
```
- migrate the database

```
$ php artisan
```
- for a list of all available commands


### Database ###

```
$ php artisan migrate
```
- migrate the database

```
$ php artisan migrate:reset
```
- reset all migrations

```
$ php artisan db:seed
```
- seed the database with dummy data