# JSON Connection File
[![Latest Stable Version](https://poser.pugx.org/darkterminal/jsonconnection/v/stable)](https://packagist.org/packages/darkterminal/jsonconnection)
[![Total Downloads](https://poser.pugx.org/darkterminal/jsonconnection/downloads)](https://packagist.org/packages/darkterminal/jsonconnection)
[![License](https://poser.pugx.org/darkterminal/jsonconnection/license)](https://packagist.org/packages/darkterminal/jsonconnection)
## Installation
```
composer require darkterminal/jsonconnection
```

## Usage
```php
<?php 

use Darkterminal\JSONConnection;

require_once 'vendor/autoload.php'; // Autoload
require_once 'PersonInSports.php'; // Your Own Rules

$database = getcwd() . '/database.json'; // path to json File
$db = new JSONConnection( $database ); // Create connection

/////////////// INSERT DATA ////////////////////
/// Rule must be similar an example
$person1 = new PersonInSports(); // Using rule
$person1
        ->code(8)
        ->name('Gatama Yarakh')
        ->sports('Surfer');   
$data = $person1->get();
$db->insert($data);
///////////////////////////////////////////////

$db->update(['Code', 8], ['Name', 'Yarakh Gatama']); // Update data

$db->selectAll(); // get all adata

$db->getLast(); // get last record

$db->find(3); // find record by Integer / String Only

$db->delete( 'Code', 7 ); // Delete data
```