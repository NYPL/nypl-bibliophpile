<?php

require 'vendor/autoload.php';

abstract class PrettyPrinter
{
    protected $resource;

    public function __construct($resource) {
        $this->resource = $resource;
    }

    protected function formatLink($l) {
        return "<a href=\"$l\">$l</a>";
    }

    protected function formatSimpleList($items) {
        $formatted = "";
        if (count($items) > 0) {
            foreach ($items as $item) {
                $formatted .= "<li>$item</li>";
            }
            $formatted = "<ul>" . $formatted . "</ul>";
        }
        return $formatted;
    }

    protected function formatSimpleResource($resource) {
        if ($resource === NULL) {
            return "";
        }
        return <<<HTML
<ul>
    <li>ID: {$resource->id()}</li>
    <li>Name: {$resource->name()}</li>
</ul>
HTML;
    }

    abstract public function prettyPrint();
}

class LibraryPrinter extends PrettyPrinter
{

    public function prettyPrint() {
        return <<<HTML
<ul>
    <li>ID: {$this->resource->id()}</li>
    <li>Name: {$this->resource->name()}</li>
    <li>Catalog: {$this->formatLink($this->resource->catalog())}</li>
</ul>
HTML;
    }
}

class TitlePrinter extends PrettyPrinter
{
    protected function formatSeries($series) {
        $formatted = "";

        if (count($series) > 0) {
            foreach ($series as $s) {
                $formatted .= <<<HTML
<li>
    <ul>
        <li>Name: {$series->name()}</li>
        <li>Number: {$series->number()}</li>
    </ul>
</li>
HTML;
            }
            $formatted = "<ul>" . $formatted . "</ul>";
        }

        return $formatted;
    }

    public function prettyPrint() {
        return <<<HTML
<ul>
    <li>ID: {$this->resource->id()}</li>
    <li>Title: {$this->resource->name()}</li>
    <li>Subtitle: {$this->resource->subtitle()}</li>
    <li>Authors: {$this->formatSimpleList($this->resource->authors())}</li>
    <li>Additional Contributors: {$this->formatSimpleList($this->resource->additionalContributors())}</li>
    <li>Publishers: {$this->formatSimpleList($this->resource->publishers())}</li>
    <li>Edition: {$this->resource->edition()}</li>
    <li>Series: {$this->formatSeries($this->resource->series())}</li>
    <li>Pages: {$this->resource->pages()}</li>
    <li>ISBNS: {$this->formatSimpleList($this->resource->isbns())}</li>
    <li>UPCS: {$this->formatSimpleList($this->resource->upcs())}</li>
    <li>Call Number: {$this->resource->callNumber()}</li>
    <li>Availability: {$this->formatSimpleResource($this->resource->availability())}</li>
    <li>Description: {$this->resource->description()}</li>
    <li>Primary Language: {$this->resource->primaryLanguage()}</li>
    <li>Languages: {$this->formatSimpleList($this->resource->languages())}</li>
    <li>Contents: {$this->formatSimpleList($this->resource->contents())}</li>
    <li>Performers: {$this->formatSimpleList($this->resource->performers())}</li>
    <li>Suitabilities: {$this->formatSimpleList($this->resource->suitabilities())}</li>
    <li>Notes: {$this->formatSimpleList($this->resource->notes())}</li>
    <li>Responsibility: {$this->resource->statementOfResponsibility()}</li>
    <li>Physical Description: {$this->formatSimpleList($this->resource->physicalDescription())}</li>
</ul>
HTML;
    }

}

class CopiesPrinter extends PrettyPrinter
{
    public function prettyPrint() {
        $formatted = "";
        foreach ($this->resource as $copy) {

            $formatted .= <<<HTML
<li>
    <ul>
        <li>Collection: {$copy->collection()}</li>
        <li>Call Number: {$copy->callNumber()}</li>
        <li>Library Status: {$copy->libraryStatus()}</li>
        <li>Location: {$this->formatSimpleResource($copy->location())}</li>
        <li>Status: {$this->formatSimpleResource($copy->status())}</li>
    </ul>
</li>
HTML;
        }
        $formatted = "<ul>" . $formatted . "</ul>";
        return $formatted;
    }

}

class ListItemTitlePrinter extends PrettyPrinter {
    public function prettyPrint() {
        $title = new TitlePrinter($this->resource->item());
        return <<<HTML
<ul>
    <li>Annotation: {$this->resource->annotation()}</li>
    <li>Title: {$title->prettyPrint()}</li>
</ul>
HTML;
    }
}

class ListItemUrlPrinter extends PrettyPrinter {
    public function prettyPrint() {
        return <<<HTML
<ul>
    <li>Annotation: {$this->resource->annotation()}</li>
    <li>Title: {$this->resource->item()->title()}</li>
    <li>URL: {$this->formatLink($this->resource->item()->url())}</li>
</ul>
HTML;
    }
}

class ListPrinter extends PrettyPrinter
{
    protected function formatItems() {
        $formatted = "";
        foreach ($this->resource->items() as $item) {
            $class = get_class($item);
            if (get_class($item) === 'NYPL\Bibliophpile\ListItemTitle') {
                $printitem = new ListItemTitlePrinter($item); 
            } else {
                $printitem = new ListItemUrlPrinter($item);                 
            }
            $formatted .= "<li>{$printitem->prettyPrint()}</li>";
        }

        return  "<ol>" . $formatted . "</ol>";
    }

    public function prettyPrint() {
        $user = new UserPrinter($this->resource->user());
        return <<<HTML
<ul>
    <li>ID: {$this->resource->id()}</li>
    <li>Name: {$this->resource->name()}</li>
    <li>Item count: {$this->resource->itemCount()}</li>
    <li>Details: {$this->formatLink($this->resource->details())}</li>
    <li>Created: {$this->resource->created()->format('Y-m-d')}</li>
    <li>Updated: {$this->resource->updated()->format('Y-m-d')}</li>
    <li>User: {$user->prettyPrint()}</li>
    <li>Items: {$this->formatItems()}</li>
</ul>
HTML;
    }
}

class UserPrinter extends PrettyPrinter
{
    public function prettyPrint() {
        return <<<HTML
<ul>
    <li>ID: {$this->resource->id()}</li>
    <li>Name: {$this->resource->name()}</li>
    <li>Profile: {$this->formatLink($this->resource->profile())}</li>
</ul>
HTML;
    }
}

if (isset($_POST['apikey'])) {
    $apikey = $_POST['apikey'];
    $searchtype = $_POST['searchtype'];
    $q = $_POST['q'];

    $client = new \NYPL\Bibliophpile\Client($apikey);

    if ($searchtype === 'library') {
        $resource = new LibraryPrinter($client->library($q));
    } elseif ($searchtype === 'title-by-id') {
        $resource = new TitlePrinter($client->title($q));
    } elseif ($searchtype === 'copies-by-id') {
        $resource = new CopiesPrinter($client->copies($q));
    } elseif ($searchtype === 'list') {
        $resource = new ListPrinter($client->itemList($q));
    } elseif ($searchtype === 'user-by-id') {
        $resource = new UserPrinter($client->user($q));
    }

} else {
    $apikey = "";
    $searchtype = "library";
    $q = "";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Bibliophpile Demo</title>
</head>

<body>
    <h1>Bibliophpile Demo</h1>

    <form method="post"> 
        <fieldset>
            <label for="apikey">Api Key</label>
            <input id="apikey" name="apikey" value="<?php echo $apikey ?>" required/>
        </fieldset>
        <fieldset>
            <legend>Search type</legend>
            <ol>
                <li>
                    <input 
                        id="radio-library" 
                        name="searchtype" 
                        type="radio" 
                        value="library"
                        <?php if ($searchtype==='library') {?> checked="checked"<?php } ?>>
                    <label for="radio-library">Library (ex: “NYPL”)</label>
                </li>
                <li>
                    <input
                        id="radio-title"
                        name="searchtype"
                        type="radio" 
                        value="title-by-id"
                        <?php if ($searchtype==='title-by-id') {?> checked="checked"<?php } ?>>
                    <label for="radio-title">Title by ID (ex: “18708779052907”)</label>
                </li>
                <li>
                    <input
                        id="radio-copies"
                        name="searchtype"
                        type="radio" 
                        value="copies-by-id"
                        <?php if ($searchtype==='copies-by-id') {?> checked="checked"<?php } ?>>
                    <label for="radio-title">Copies of a title by ID (ex: “18708779052907”)</label>
                </li>
                <li>
                    <input
                        id="radio-list"
                        name="searchtype"
                        type="radio" 
                        value="list"
                        <?php if ($searchtype==='list') {?> checked="checked"<?php } ?>>
                    <label for="radio-list">List by ID (ex: “170265611”)</label>
                </li>
                <li>
                    <input
                        id="radio-user"
                        name="searchtype"
                        type="radio" 
                        value="user-by-id"
                        <?php if ($searchtype==='user-by-id') {?> checked="checked"<?php } ?>>
                    <label for="radio-user">User by ID (ex: “169884281”)</label>
                </li>
            </ol>
        </fieldset>
        <fieldset>
            <label for="q">Search for</label>
            <input id="q" name="q" type="text" value="<?php echo $q ?>" required/>
        </fieldset>

        <fieldset>
            <button type=submit>Submit</button>
        </fieldset>
    </form>

    <div>
        <?php
            if (isset($_POST['q'])) {

                echo $resource->prettyPrint();
            }
        ?>
    </div>
</body>
</html>