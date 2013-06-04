# NYPL Bibliophpile

PHP Wrapper for [BiblioCommons](http://www.bibliocommons.com/) API

## Installation

Clone the repository, `cd` onto your cloned directory and run composer:

    php composer.phar install 
    php composer.phar install --dev


## Run tests

	alias phpunit='php vendor/phpunit/phpunit/phpunit.php'

    phpunit tests

or

    phpunit --testdox tests

## Generate Documentation

Work fine with [PHPDocumentor](http://www.phpdoc.org/) (and probably others as well).

    phpdoc -d src -t docs

To install PHPDocumentor:

	pear channel-discover pear.phpdoc.org
	pear install phpdoc/phpDocumentor-alpha

NOTE: You may have to also install <a href="http://www.graphviz.org/">GraphViz</a> in order for phpdoc to run without errors.
