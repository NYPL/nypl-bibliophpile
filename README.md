# NYPL Bibliophpile

PHP Wrapper for [BiblioCommons](http://www.bibliocommons.com/) API

## Credit

Originally written by The New York Public Library: https://www.nypl.org/

Currently maintained by Multnomah County Library: https://multcolib.org/

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

## Run the Demo

If your are using PHP 5.4 or greater, you can use the built-in web server to run the demo:

    php -S localhost:8000

Then go to browser and open `http://localhost:8000/demo.php

## Basic Usage

Create a client:

    $client = new \NYPL\Bibliophpile\Client('yourapikey');

Via the client you can retrieve the various other BiblioCommons API resources:

    $library = $client->library('nypl'); // Returns a Library
    $locations = $client->location('nypl'); // Returns a list of Location objects
    $list = $client->itemList('1234567'); // Returns an ItemList
    $title = $client->title('123456789'); // Returns a Title
    $titles = $client->titles('Moby Dick', 'nypl'); // Returns a list of matching Title objects
    $user = $client->user('1234567'); // Returns a User
    $users = $client->users('example'); // Returns a list of matching User objects
    $session = $client->session('a1b2c3d4-e5f6-g7h9-i9j0-k1l2m3n4o5p6'); // Returns a Session
    $borrower = $client->borrower('123456'); // Returns a Borrower                       


## A note about IDs

Many of the IDs in the examples above are clearly integer-like, but they passed and returned as strings.

## Paginated Lists

Some methods return `ItemLists` `Titles` or `Users` objects, which are all paginated lists. Any method that returns a paginated list takes both a `page` and a `limit` parameter for the desired page from the results (default: 1) and the number of results per page (default: 10). For example:

    // Searches NYPL for “Moby Dick” and returns the 5th page 
    // with 20 items per page.
    // Returns a Titles object
    $client->titles('Moby Dick', 'nypl', 5, 20);

    // Gets the 2nd page of lists made by the user, with the 
    // default 10 items per page.
    // Returns a Users object.
    $user->userLists('123456', 2);

The objects themselves share the following methods:

* `count()`: Returns the total number of items in the results
* `page()`: Returns the current page out the results
* `pages()`: Returns the number of pages in the results
* `limit()`: Returns the number of items per page
* `gotoPage(page)`: Retrieves the desired page of results.
* `next()`: Retrieves the next page of results.

Trying to get a page that does not exist (less than 1 or higher than the highest numbered page in the results) will raise a `NoSuchPageException`. Trying to get the next page when you are already at the end of the results raises an `EndOfResultsException` which can be caught and used a signal to exit a loop when fetching the entire results set. 

## Empty properties

Many objects returned by the BiblioCommons API can have empty, null, or missing properties. Nypl-bibliophpile handles all these cases by returning an empty array for properties that are expected to be arrays, or `NULL` for enything else.

## Resources

### Libraries

Library objects can be retrieved by ID:

    $library = $client->library('nypl');
    echo $library->id(); // "nypl"
    echo $library->name(); // "New York Public Library"
    echo $library->catalog(); // "http://nypl.bibliocommons.com"

### Locations

A library can have a multiple locations (basically branches). The list of a library’s locations can be retrieved from the Library object:

    $locations = $library->locations();
    echo $locations[0]->name(); // "115th Street"

or from the client with the library’s ID:

    $locations = $client->locations('nypl');

Individual locations also occur as properties in Copy (location of a particular copy) and Borrower  objects (as a borrower’s preferred location).

### Titles

A “title” can be a book, a DVD, a CD, or anything that can be checked out. 

Methods:
<table>
    <tbody>
        <tr>
            <td>additionalContributors()</td>
            <td>array</td>
            <td>Additional contributors as an array of names (strings)</td>
        </tr>
        <tr>
            <td>authors()</td>
            <td>array</td>
            <td>Authors names as an array strings.</td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td>availability()</td>
            <td>Availability</td>
            <td></td>
        </tr>
        <tr>
            <td>callNumber()</td>
            <td>string</td>
            <td></td>
        </tr>
        <tr>
            <td>contents()</td>
            <td>array</td>
            <td>Table of contents as an array of strings.</td>
        </tr>
        <tr>
            <td>copies()</td>
            <td>array</td>
            <td>An array of Copy objects.</td>
        </tr>
        <tr>
            <td>description()</td>
            <td>string</td>
            <td></td>
        </tr>
        <tr>
            <td>details()</td>
            <td>string</td>
           <td>URL for the title on BiblioCommons.</td>
        </tr>
        <tr>
            <td>edition()</td>
            <td>string</td>
        </tr>
        <tr>
            <td>format()</td>
            <td>Format</td>
        </tr>
        <tr>
            <td>id()</td>
            <td>string</td>
        </tr>
        <tr>
            <td>isbns()</td>
            <td>array</td>
            <td>An array of the title's isbns as strings.</td>
        </tr>
        <tr>
            <td>languages()</td>
            <td>array</td>
            <td>Array of the title's languages as strings.</td>
        </tr>
        <tr>
            <td>name()</td>
            <td>string</td>
            <td>Returns the title's name (i.e. it's title, but this method can’t be called title() in order to avoid confusion with a constructor).</td>
        </tr>
        <tr>
            <td>notes()</td>
            <td>array</td>
            <td>Notes on the title as an array of strings.</td>
        </tr>
        <tr>
            <td>pages()</td>
            <td>int</td>
            <td>The number of pages</td>
        </tr>
        <tr>
            <td>performers()</td>
            <td>array</td>
            <td>Title's performers and an array of strings.</td>
        </tr>
        <tr>
            <td>physicalDescription()</td>
            <td>array</td>
            <td>Physical description of the title as an array of strings.</td>
        </tr>
        <tr>
            <td>primaryLanguage()</td>
            <td>string</td>
        </tr>
        <tr>
            <td>publishers()</td>
            <td>array</td>
            <td>Array of publishers names as strings.</td>
        </tr>
        <tr>
            <td>series()</td>
            <td>array</td>
            <td>An array of Series objects.</td>
        </tr>
        <tr>
            <td>statementOfResponsibility()</td>
            <td>string</td>
        </tr>
        <tr>
            <td>subtitle()</td>
            <td>string</td>
        </tr>
        <tr>
            <td>suitabilities()</td>
            <td>array</td>
            <td>An array of strings.</td>
        </tr>
        <tr>
            <td>upcs()</td>
            <td>array</td>
            <td>The title's upcs as an array of strings.</td>
        </tr>
    </tbody>
</table>

## Lists

BiblioCommons lists are user-generated lists of Titles

Retrieve a list by it's ID:

    $list = $client->itemList('170265611');
    echo $list->name(); // "Recommended by our librarians 4";


## Titles

Retrieve a title by its ID (NB, the IDs are numeric, but still strings):

    $title = $client->title('18708779052907');
    echo $title->name(); // "Moby-Dick";

Retrieve the copies of a title:

    $copies = $title->copies(); // Array of copy objects

You can also get the copies from the client with the title’s ID:

    $copies = $client->copies('18708779052907');

## Users

Retrieve a user by ID:

    $user = $client->user('123456789');
    echo $user->name(); // "fakeuser"

Search for users by username:

    $users = $client->users('fakeuser');
    $userlist = $users->users(); // array of results
    count($users->users()); // 1
    echo $userlist[0]->name(); // "fakeuser"

