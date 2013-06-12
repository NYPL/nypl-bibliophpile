# Using nypl-bibliophpile

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
* next(): Retrieves the next page of results.

Trying to get a page that does not exist (less than 1 or higher than the highest numbered page in the results) will raise a `NoSuchPageException`. Trying to get the next page when you are already at the end of the results raises an `EndOfResultsException`. 

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


