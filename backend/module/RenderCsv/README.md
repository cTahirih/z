# RenderCsv Module

## Authors
Jaime G. Wong \<j@jgwong.org>


## How to use
This is a Controller Plugin for rendering a `League\Csv\AbstractCsv` object for download.

It's straightforward. Once you have a Writer or Reader object, you can send it to the browser from the Controller doing:

    return $this->renderCsv($csv, 'export.csv');

Where `$csv` is your `Writer` or `Reader` object. The filename is optional and defaults to `export.csv`.

The plugin returns a `Zend\Http\Response` object you can either return or further manipulate if you will.

The `Response` has all the HTTP headers needed for the download. The encoding is set according to the one set on the CSV.


### Caveat: Microsoft Excel and BOM
Microsoft Excel won't read CSVs properly unless they include a BOM character. For this, set the BOM on the `AbstractCSV` object like this:

    $csv->setOutputBom(Reader::BOM_UTF8);

Replace `Reader::` with `Writer::` if you're using a `Writer` class instead. [See this page for more information](http://csv.thephpleague.com/8.0/bom/).


## Requisites
The only requisite is [PHP League's CSV library](http://csv.thephpleague.com/).

    composer require league/csv:^9.1
