CMS Lo Pati v5.0
================

A fresh new Symfony 5.4 LTS CMS webapp project to manage a Lo Pati content resources.

---

#### Installation requirements

* PHP 7.4
* MySQL 8.0
* Git 2.0
* Composer 2.0

#### Installation instructions

```bash
$ git git@github.com:Flexible-User-Experience/lo-pati-5.git
$ cd lo-pati-5
$ cp env.dist .env
$ nano .env
$ composer install
```

Remember to edit `.env` config file according to your system environment needs.

#### Testing suite commands

```bash
$ ./scripts/developer-tools/test-database-reset.sh
$ ./scripts/developer-tools/run-test.sh
```
