# Basic Usage

Create a client:

    $client = new \NYPL\Bibliophpile\Client('yourapikey');

## Libraries
Find a library by its ID:

    $library = $client->library('nypl');
    echo $library->name(); // "New York Public Library"

Retrieve the library’s locations:

    $locations = $library->locations();
    echo $locations[0]->name(); // "115th Street"

You can also get the locations directly from the client with the library’s id:

    $locations = $client->locations('nypl');

## Titles

Retrieve a title by its ID (NB, the IDs are numeric, but still strings):

    $title = $client->title('18708779052907');
    echo $title->name(); // "Moby-Dick";

Retrieve the copies of a title:

    $copies = $title->copies(); // Array of copy objects

You can also get the copies from the client with the title’s ID:

    $copies = $client->copies('18708779052907');



