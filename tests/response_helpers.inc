<?php 
$_library_response = <<<'JSON'
{
  "library": {
      "catalog_url": "http://nypl.bibliocommons.com",
      "id": "nypl",
      "name": "New York Public Library"
  }
}
JSON;

$_locations_response = <<<'JSON'
{
    "locations": [
        {
            "id": "52-HU",
            "name": "115th Street"
        },
        {
            "id": "52-HD",
            "name": "125th Street"
        },
        {
            "id": "52-FE",
            "name": "58th Street"
        },
        {
            "id": "52-SS",
            "name": "67th Street"
        }
    ]
}
JSON;

// https://api.bibliocommons.com/v1/lists?api_key=...
$_lists_response = <<<'JSON'
{
    "count": 4,
    "limit": 4,
    "lists": [
        {
            "created": "2013-03-12T11:14:42Z",
            "description": null,
            "details_url": "http://any.bibliocommons.com/list/show/149422981/159567325",
            "id": "159567325",
            "item_count": 2,
            "language": "en-US",
            "list_type": {
                "id": "TOPIC_GUIDE",
                "name": "Topic Guide"
            },
            "name": "My Favorite Science and Nature Books",
            "updated": "2013-03-12T11:16:51Z",
            "user": {
                "id": "149422981",
                "name": "red_monkey_2384",
                "profile_url": "http://any.bibliocommons.com/collection/show/149422981"
            }
        },
        {
            "created": "2012-11-12T20:26:39Z",
            "description": null,
            "details_url": "http://any.bibliocommons.com/list/show/137981261/138453972",
            "id": "138453972",
            "item_count": 14,
            "language": "en-US",
            "list_type": {
                "id": "TOP_10",
                "name": "Top 10 List"
            },
            "name": "My favourite vampire books",
            "updated": "2012-11-12T20:29:51Z",
            "user": {
                "id": "137981261",
                "name": "natasha47",
                "profile_url": "http://any.bibliocommons.com/collection/show/137981261"
            }
        },
        {
            "created": "2012-11-12T19:30:02Z",
            "description": null,
            "details_url": "http://any.bibliocommons.com/list/show/138443571/138445620",
            "id": "138445620",
            "item_count": 6,
            "language": "en-US",
            "list_type": {
                "id": "TOPIC_GUIDE",
                "name": "Topic Guide"
            },
            "name": "My Favorite Stories",
            "updated": "2012-11-12T19:31:11Z",
            "user": {
                "id": "138443571",
                "name": "red_alligator_3792",
                "profile_url": "http://any.bibliocommons.com/collection/show/138443571"
            }
        },
        {
            "created": "2012-11-12T19:17:06Z",
            "description": null,
            "details_url": "http://any.bibliocommons.com/list/show/138443571/138444072",
            "id": "138444072",
            "item_count": 8,
            "language": "en-US",
            "list_type": {
                "id": "TOP_10",
                "name": "Top 10 List"
            },
            "name": "My Favorite Fairy Tales",
            "updated": "2012-11-12T19:25:25Z",
            "user": {
                "id": "138443571",
                "name": "red_alligator_3792",
                "profile_url": "http://any.bibliocommons.com/collection/show/138443571"
            }
        }
    ],
    "page": 1,
    "pages": 1
}
JSON;

// Based on https://api.bibliocommons.com/v1/titles/18708779052907?api_key=...
$_title_response = <<<'JSON'
{
    "title": {
        "additional_contributors": [
            {
                "name": "Walcutt, Charles Child"
            }
        ],
        "authors": [
            {
                "name": "Melville, Herman"
            }
        ],
        "availability": {
            "id": "AVAILABLE",
            "name": "Available"
        },
        "call_number": "CLASSICS FIC M",
        "contents": [],
        "description": "",
        "details_url": "http://any.bibliocommons.com/item/show/18708779052907",
        "edition": "",
        "format": {
            "id": "PAPERBACK",
            "name": "Paperback"
        },
        "id": "18708779052907",
        "isbns": [
            "0553213113",
            "9780553213119"
        ],
        "languages": [
            {
                "name": "English"
            }
        ],
        "notes": [
            "\"First published in 1851.\"",
            "\"Bantam Classic reissue.\"",
            "\"A Bantam book.\"",
            "Includes bibliographical references (p. [668]-670)"
        ],
        "pages": 670,
        "performers": [
            {
                "name": "Performer One"
            },
            {
                "name": "Performer Two"
            }
        ],
        "physical_description": [
            "xxvii, 670 p. ;,18 cm."
        ],
        "primary_language": {
            "name": "English"
        },
        "publication_date": "2003",
        "publishers": [
            {
                "name": "Bantam Classic"
            }
        ],
        "series": [],
        "statement_of_responsibility": "Herman Melville ; edited and with an introduction by Charles Child Walcutt",
        "sub_title": "",
        "suitabilities": [
            {
                "name": "First Suitability"
            },
            {
                "name": "Second Suitability"

            }
        ],
        "title": "Moby-Dick"
    }
}
JSON;

// Short version of previous response returned as part of the list of titles by
// https://api.bibliocommons.com/v1/titles?api_key=...&q=Moby+Dick&library=nypl
$_title_short_response = <<<'JSON'
{
    "authors": [
        {
            "name": "Melville, Herman"
        }
    ],
    "availability": {
        "id": "AVAILABLE",
        "name": "Available to borrow"
    },
    "details_url": "http://nypl.bibliocommons.com/item/show/18708779052907",
    "format": {
        "id": "PAPERBACK",
        "name": "Paperback"
    },
    "id": "18708779052907",
    "isbns": [
        "0553213113",
        "9780553213119"
    ],
    "primary_language": {
        "name": "English"
    },
    "publication_date": "2003",
    "sub_title": "",
    "title": "Moby-Dick"
}
JSON;

$_series_response_number = <<<'JSON'
{
    "name": "Series Title",
    "number": "1"
}
JSON;

$_series_response_no_number = <<<'JSON'
{
    "name": "Numberless Series Title",
    "number": ""
}
JSON;

$_bad_json = "This isn't JSON";

