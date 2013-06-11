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

$_users_by_id_response = <<<'JSON'
{
    "user": {
        "id": "123456789",
        "name": "fakeuser",
        "profile_url": "http://any.bibliocommons.com/collection/show/123456789"
    }
}
JSON;

$_lists_response = <<<'JSON'
{
    "count": 13,
    "limit": 2,
    "lists": [
        {
            "created": "2013-06-04T17:46:34Z",
            "description": null,
            "details_url": "http://any.bibliocommons.com/list/show/169884281/176809673",
            "id": "176809673",
            "item_count": 32,
            "language": "en-US",
            "list_type": {
                "id": "OTHER",
                "name": "Other"
            },
            "name": "Recently arrived eBooks 3",
            "updated": "2013-06-04T18:05:08Z"
        },
        {
            "created": "2013-06-04T17:33:32Z",
            "description": "Recently arrived eBooks from Macmillan",
            "details_url": "http://any.bibliocommons.com/list/show/169884281/176804995",
            "id": "176804995",
            "item_count": 32,
            "language": "en-US",
            "list_type": {
                "id": "OTHER",
                "name": "Other"
            },
            "name": "Recently arrived eBooks 2",
            "updated": "2013-06-04T19:26:16Z"
        }
    ],
    "page": 1,
    "pages": 7
}
JSON;

$_lists_response_p2 = <<<'JSON'
{
    "count": 13,
    "limit": 2,
    "lists": [
        {
            "created": "2013-06-04T17:06:47Z",
            "description": "Recently arrived eBooks published by Hachette",
            "details_url": "http://any.bibliocommons.com/list/show/169884281/176796343",
            "id": "176796343",
            "item_count": 32,
            "language": "en-US",
            "list_type": {
                "id": "OTHER",
                "name": "Other"
            },
            "name": "Recently arrived eBooks",
            "updated": "2013-06-04T17:30:35Z"
        },
        {
            "created": "2013-05-05T23:46:27Z",
            "description": null,
            "details_url": "http://any.bibliocommons.com/list/show/169884281/170407471",
            "id": "170407471",
            "item_count": 32,
            "language": "en-US",
            "list_type": {
                "id": "OTHER",
                "name": "Other"
            },
            "name": "Recently arrived 3",
            "updated": "2013-05-06T01:26:32Z"
        }
    ],
    "page": 2,
    "pages": 7
}
JSON;

$_lists_response_p7 = <<<'JSON'
{
    "count": 13,
    "limit": 2,
    "lists": [
        {
            "created": "2013-05-02T20:45:30Z",
            "description": null,
            "details_url": "http://any.bibliocommons.com/list/show/169884281/169886331",
            "id": "169886331",
            "item_count": 32,
            "language": "en-US",
            "list_type": {
                "id": "OTHER",
                "name": "Other"
            },
            "name": "Recommended by our librarians",
            "updated": "2013-05-04T23:16:50Z"
        }
    ],
    "page": 7,
    "pages": 7
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
        "contents": [
            "First contents line",
            "Second contents line"
        ],
        "description": "A description",
        "details_url": "http://any.bibliocommons.com/item/show/18708779052907",
        "edition": "The Edition",
        "format": {
            "id": "PAPERBACK",
            "name": "Paperback"
        },
        "id": "18708779052907",
        "isbns": [
            "0553213113",
            "9780553213119"
        ],
        "upcs": [
            "1234567890",
            "0987654321"
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
        "series": [
            {
                "name": "Series Title",
                "number": "1"
            }
        ],
        "statement_of_responsibility": "Herman Melville ; edited and with an introduction by Charles Child Walcutt",
        "sub_title": "With a subtitle",
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
// Based onhttps://api.bibliocommons.com/v1/titles?api_key=...&q=Moby+Dick&library=nypl
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
    "title": "Moby-Dick"
}
JSON;

$_title_copies_response = <<<'JSON'
{
    "copies": [
        {
            "call_number": "CLASSICS FIC M", 
            "collection": "Fort Washington Fiction", 
            "library_status": "DUE", 
            "location": {
                "id": "52-FW", 
                "name": "Fort Washington"
            }, 
            "status": {
                "id": "UNAVAILABLE", 
                "name": "All copies in use"
            }
        }, 
        {
            "call_number": "CLASSICS FIC M", 
            "collection": "Fort Washington Fiction", 
            "library_status": "AVAILABLE", 
            "location": {
                "id": "52-FW", 
                "name": "Fort Washington"
            }, 
            "status": {
                "id": "AVAILABLE", 
                "name": "Available"
            }
        }, 
        {
            "call_number": "CLASSICS FIC M", 
            "collection": "Francis Martin Fiction", 
            "library_status": "AVAILABLE", 
            "location": {
                "id": "52-FX", 
                "name": "Francis Martin"
            }, 
            "status": {
                "id": "AVAILABLE", 
                "name": "Available"
            }
        }, 
        {
            "call_number": "CLASSICS FIC M", 
            "collection": "Grand Central Fiction", 
            "library_status": "DUE", 
            "location": {
                "id": "52-GC", 
                "name": "Grand Central"
            }, 
            "status": {
                "id": "UNAVAILABLE", 
                "name": "All copies in use"
            }
        }, 
        {
            "call_number": "CLASSICS FIC M", 
            "collection": "Grand Central Fiction", 
            "library_status": "AVAILABLE", 
            "location": {
                "id": "52-GC", 
                "name": "Grand Central"
            }, 
            "status": {
                "id": "AVAILABLE", 
                "name": "Available"
            }
        }, 
        {
            "call_number": "CLASSICS FIC M", 
            "collection": "Parkchester Fiction", 
            "library_status": "DUE", 
            "location": {
                "id": "52-PK", 
                "name": "Parkchester"
            }, 
            "status": {
                "id": "UNAVAILABLE", 
                "name": "All copies in use"
            }
        }, 
        {
            "call_number": "CLASSICS FIC M", 
            "collection": "Pelham Bay Fiction", 
            "library_status": "DUE", 
            "location": {
                "id": "52-PM", 
                "name": "Pelham Bay"
            }, 
            "status": {
                "id": "UNAVAILABLE", 
                "name": "All copies in use"
            }
        }, 
        {
            "call_number": "CLASSICS FIC M", 
            "collection": "Pelham Bay Fiction", 
            "library_status": "AVAILABLE", 
            "location": {
                "id": "52-PM", 
                "name": "Pelham Bay"
            }, 
            "status": {
                "id": "AVAILABLE", 
                "name": "Available"
            }
        }
    ]
}
JSON;

// https://api.bibliocommons.com/v1/titles?api_key=...&q=Moby+Dick&library=nypl&limit=2
$_titles_search_response = <<<'JSON'
{
    "count": 412,
    "limit": 2,
    "page": 1,
    "pages": 206,
    "titles": [
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
        },
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
            "details_url": "http://nypl.bibliocommons.com/item/show/17230484052907",
            "format": {
                "id": "BK",
                "name": "Book"
            },
            "id": "17230484052907",
            "primary_language": {
                "name": "English"
            },
            "publication_date": "1981",
            "sub_title": "",
            "title": "Moby-Dick"
        }
    ]
}
JSON;

$_titles_search_response_p2 = <<<'JSON'
{
    "count": 412,
    "limit": 2,
    "page": 2,
    "pages": 206,
    "titles": [
        {
            "authors": [
                {
                    "name": "Melville, Herman"
                }
            ],
            "availability": null,
            "details_url": "http://nypl.bibliocommons.com/item/show/19655776052907",
            "format": {
                "id": "EBOOK",
                "name": "eBook"
            },
            "id": "19655776052907",
            "isbns": [
                "9781620117002",
                "1620117002"
            ],
            "primary_language": {
                "name": "English"
            },
            "publication_date": "2012",
            "sub_title": "Or, The Whale",
            "title": "Moby Dick"
        },
        {
            "authors": [
                {
                    "name": "Kimmel, Eric A."
                }
            ],
            "availability": {
                "id": "AVAILABLE",
                "name": "Available to borrow"
            },
            "details_url": "http://nypl.bibliocommons.com/item/show/19668330052907",
            "format": {
                "id": "BK",
                "name": "Book"
            },
            "id": "19668330052907",
            "isbns": [
                "9780312662974",
                "0312662971"
            ],
            "primary_language": {
                "name": "English"
            },
            "publication_date": "2012",
            "sub_title": "Chasing the Great White Whale",
            "title": "Moby Dick"
        }
    ]
}
JSON;

$_titles_search_response_p206 = <<<'JSON'
{
    "count": 412,
    "limit": 2,
    "page": 206,
    "pages": 206,
    "titles": [
        {
            "authors": [],
            "availability": {
                "id": "LIBRARY_USE_ONLY",
                "name": "In-library use only"
            },
            "details_url": "http://nypl.bibliocommons.com/item/show/16829330052907",
            "format": {
                "id": "BK",
                "name": "Book"
            },
            "id": "16829330052907",
            "isbns": [
                "9780262633635",
                "0262633639"
            ],
            "primary_language": {
                "name": "English"
            },
            "publication_date": "2008",
            "sub_title": "Sampling Digital Music and Culture",
            "title": "Sound Unbound"
        },
        {
            "authors": [],
            "availability": {
                "id": "AVAILABLE",
                "name": "Available to borrow"
            },
            "details_url": "http://nypl.bibliocommons.com/item/show/17366912052907",
            "format": {
                "id": "BK",
                "name": "Book"
            },
            "id": "17366912052907",
            "isbns": [
                "0262633639",
                "9780262633635"
            ],
            "primary_language": {
                "name": "English"
            },
            "publication_date": "2008",
            "sub_title": "Sampling Digital Music and Culture",
            "title": "Sound Unbound"
        }
    ]
}
JSON;
$_list_response = <<<'JSON'
{
    "list": {
        "created": "2013-05-04T23:17:52Z", 
        "description": null, 
        "details_url": "http://any.bibliocommons.com/list/show/169884281/170265611", 
        "id": "170265611", 
        "item_count": 5, 
        "language": "en-US", 
        "list_items": [
            {
                "annotation": "", 
                "list_item_type": "title", 
                "title": {
                    "authors": [
                        {
                            "name": "Stasiuk, Andrzej"
                        }
                    ], 
                    "details_url": "http://any.bibliocommons.com/item/show/19776821052", 
                    "format": {
                        "id": "BK", 
                        "name": "Book"
                    }, 
                    "id": "19776821052", 
                    "isbns": [
                        "9780151012718", 
                        "0151012717"
                    ], 
                    "primary_language": {
                        "name": "English"
                    }, 
                    "publication_date": "2011", 
                    "sub_title": "Travels in the Other Europe", 
                    "title": "On the Road to Babadag"
                }
            }, 
            {
                "annotation": "", 
                "list_item_type": "title", 
                "title": {
                    "authors": [
                        {
                            "name": "Jacobson, Howard"
                        }
                    ], 
                    "details_url": "http://any.bibliocommons.com/item/show/19682219052", 
                    "format": {
                        "id": "BK", 
                        "name": "Book"
                    }, 
                    "id": "19682219052", 
                    "isbns": [
                        "9781608199389", 
                        "160819938X"
                    ], 
                    "primary_language": {
                        "name": "English"
                    }, 
                    "publication_date": "2012", 
                    "sub_title": "A Novel", 
                    "title": "Zoo Time"
                }
            }, 
            {
                "annotation": "", 
                "list_item_type": "title", 
                "title": {
                    "authors": [
                        {
                            "name": "Brill, Steven"
                        }
                    ], 
                    "details_url": "http://any.bibliocommons.com/item/show/18978764052", 
                    "format": {
                        "id": "BK", 
                        "name": "Book"
                    }, 
                    "id": "18978764052", 
                    "isbns": [
                        "9781451611991", 
                        "1451611994"
                    ], 
                    "primary_language": {
                        "name": "English"
                    }, 
                    "publication_date": "2011", 
                    "sub_title": "Inside the Fight to Fix America's Schools", 
                    "title": "Class Warfare"
                }
            }, 
            {
                "annotation": "", 
                "list_item_type": "title", 
                "title": {
                    "authors": [
                        {
                            "name": "Mandanna, Sarita"
                        }
                    ], 
                    "details_url": "http://any.bibliocommons.com/item/show/18793844052", 
                    "format": {
                        "id": "BK", 
                        "name": "Book"
                    }, 
                    "id": "18793844052", 
                    "isbns": [
                        "9780446564106", 
                        "0446564109"
                    ], 
                    "primary_language": {
                        "name": "English"
                    }, 
                    "publication_date": "2011", 
                    "sub_title": "", 
                    "title": "Tiger Hills"
                }
            }, 
            {
                "list_item_type": "url",
                "annotation": "Check out this cool online version of Oliver Twist.",
                "url": {
                    "title": "Oliver Twist by Charles Dickens.",
                    "url": "http://www.online-literature.com/dickens/olivertwist/"
                }
            }
        ], 
        "list_type": {
            "id": "OTHER", 
            "name": "Other"
        }, 
        "name": "Recommended by our librarians 4", 
        "updated": "2013-05-05T00:53:59Z", 
        "user": {
            "id": "169884281", 
            "name": "BCD2013", 
            "profile_url": "http://any.bibliocommons.com/collection/show/169884281"
        }
    }
}
JSON;

$_users_response = <<<'JSON'
{
  "count": 1,
  "limit": 1,
  "pages": 1,
  "page": 1,    
  "users": [
    {
      "id": "2412321",
      "name": "exampleuser",
      "profile_url": "http://examplepl.bibliocommons.com/collection/show/2412321"
    }
  ] 
}
JSON;

$_list_short_response = <<<'JSON'
{
    "list": {
        "created": "2013-05-04T23:17:52Z", 
        "details_url": "http://any.bibliocommons.com/list/show/169884281/170265611", 
        "id": "170265611", 
        "item_count": 1, 
        "list_items": [
            {
                "annotation": "", 
                "list_item_type": "title", 
                "title": {
                    "authors": [
                        {
                            "name": "Stasiuk, Andrzej"
                        }
                    ], 
                    "details_url": "http://any.bibliocommons.com/item/show/19776821052", 
                    "format": {
                        "id": "BK", 
                        "name": "Book"
                    }, 
                    "id": "19776821052", 
                    "isbns": [
                        "9780151012718", 
                        "0151012717"
                    ], 
                    "primary_language": {
                        "name": "English"
                    }, 
                    "publication_date": "2011", 
                    "sub_title": "Travels in the Other Europe", 
                    "title": "On the Road to Babadag"
                }
            }
        ], 
        "name": "Recommended by our librarians 4", 
        "updated": "2013-05-05T00:53:59Z", 
        "user": {
            "id": "169884281", 
            "name": "BCD2013", 
            "profile_url": "http://any.bibliocommons.com/collection/show/169884281"
        }
    }
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

$_status_response = <<<'JSON'
{
    "id": "AVAILABLE",
    "name": "Available"
}
JSON;

$_list_type_response = <<<'JSON'
"list_type": {
    "id": "OTHER", 
    "name": "Other"
}
JSON;

$_list_item_url_response = <<<'JSON'
{
    "list_item_type": "url",
    "annotation": "Check out this cool online version of Oliver Twist.",
    "url": {
        "title": "Oliver Twist by Charles Dickens.",
        "url": "http://www.online-literature.com/dickens/olivertwist/"
    }
}
JSON;

$_list_item_title_response = <<<'JSON'
{
    "list_item_type": "title", 
    "title": {
        "id": "705528135",
        "title": "Alice in Wonderland",
        "format": {
            "id": "BK",
            "name": "Book"
        },
        "details_url": "http://examplepl.bibliocommons.com/item/show/705528135",
        "authors": [
            {
                "name": "Carroll, Lewis"
            }
        ],
        "isbns": [
            "0375866418",
            "9780375866418"
        ]
    }
}
JSON;

$_session_response = <<<'JSON'
{
  "session": {
    "id": "2412321",
    "name": "exampleuser",
    "borrower_id": "123456"
  }
}
JSON;

$_no_session_response = <<<'JSON'
{
    "error": {
        "message": "No session 'a123b4cd-5e67-8901-f234-g56h78901ij2' found.",
        "request": "/sessions/a123b4cd-5e67-8901-f234-g56h78901ij2?api_key=12345"
        }
}
JSON;

$_borrower_response = <<<'JSON'
{
  "borrower": {
    "id": "654321",
    "barcode": "123456789012",
    "library_borrower_type": "p",
    "email": "example@example.com",
    "first_name": "Example",
    "last_name": "User",
    "expiry_date": "2013-01-31T00:00:00Z",
    "birth_date": "1973-01-01T00:00:00Z", 
    "location": {
      "id": "AL",
      "name": "Anytown Library"
    },
    "user": {
      "id": "987654321",
      "name": "exampleuser",
      "profile_url": "http://examplepl.bibliocommons.com/collection/show/987564321"
    },
    "interest_groups": [
      {
        "id": "teacher_high_school",
        "name": "Teacher - High School"
      },
      {
        "id": "writer",
        "name": "Author/Writer/Journalist/Poet"
      }
    ]
  }
}
JSON;

$_bad_json = "This isn't JSON";

$_bc_timeout_Response = "<h1>504 Gateway Timeout</h1>";

