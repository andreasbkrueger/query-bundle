========
Overview
========

todo!

Installation
------------

Add this into your composer.json

Repository
::

    "repositories": [
        {
            "type" : "vcs",
            "url" : "git@github.com:andreasbkrueger/QueryBundle.git"
        }
    ],


Requirement
::

    "require": {
        "ABK/query-bundle": "0.1.1"
    }


On the command line run:
::

    php composer.phar update ABK/query-bundle



Include the dependency of the bundle into your AppKernel.php
::

        $bundles = array(
            ...
            new ABK\QueryBundle\ABKQueryBundle()
        );


Place this line into your config.yml to use the default configuration
::

    abk_query: ~



Configuration
-------------

This shows the full configuration options.
::

    abk_query: ~


Usage
-----

todo!

Examples
--------

todo!