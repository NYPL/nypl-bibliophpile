# Basic Usage

Create a client:

    $client = new \NYPL\Bibliophpile\Client('yourapikey');

## Libraries
Find a library by its ID:

    $library = $client->library('nypl');
    echo $library->name(); // "New York Public Library"

Retrieve the library's locations:

    $locations = $library->locations();
    echo $locations[0]; // "115th Street"

You can also get the locations directly:

    $client->locations('nypl');

## Titles

Retrieve a title by its ID (NB, the IDs are numeric, but still strings):

    $title = $client->title('18708779052907');
    echo $title->name(); // "Moby-Dick";