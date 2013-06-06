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