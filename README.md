# Wisembly

This repo is the code of [wisembly website], made on top of [Wisembly silexCMS].

## Install

* clone repository

`git clone git://github.com/Wisembly/wisembly.git`

* initialise submodules (Twitter bootstrap, jQuery..)

`git submodule update --init`

* get composer

* install vendors

`php composer.php install`

* duplicate every .dist file in `app/config/`, `web/fr|en/` and tweak them as need

* import `bin/database_structure.sql`
 
**That's it!**

  [wisembly website]: http://wisembly.net/
  [Wisembly silexCMS]: http://github.com/Wisembly/SilexCMS/

## Licence

MIT Licence

## Authors

* @nicolaschenet
* @arcanis
* @guillaumepotier