# Optimove
PHP Optimove API client.


## Requirements
- PHP 7
- Curl

## Implemented API calls:
- general/login
- integrations/AddPromotions
- integrations/GetPromotions
- integrations/DeletePromotions

## Example
```
<?php
use GenesisGlobal\Optimove\Client;

$username = 'foo';
$password = 'password';
$client = new Client($username, $password);


$promotions = [
  ["PromoCode" => "WB23", "PromotionName" => "Welcome back Promo"}],
  ["PromoCode" => "NV10", "PromotionName" => "New VIP 10% Discount"]
];
$client->promotions()->AddPromotions($promotions);

?>
```

## Reference
`Client` object has methods which returns objects for specific API parts.
`Client`'s available methods:
- `general()` - returns object for `general/*` calls
- `promotions()` - returns object for `promotions/*` calls

### Client
This is main object which contains all methods which you need to use Optimove API.

#### __construct(string $username, string $password)
Client constructor require following arguments:
- string `$username` - Optimove account username
- string `$password` - Optimove account password

##### Example:
```
<?php
use GenesisGlobal\Optimove\Client;

$username = 'foo';
$password = 'password';
$client = new Client($username, $password);
```

#### general() :General
Method returns `General` object.

##### Example:
```
<?php
use GenesisGlobal\Optimove\Client;

$username = 'foo';
$password = 'password';
$client = new Client($username, $password);

$general = $client->general();
```

#### promotions() :Promotions
Method returns `Promotions` object.

##### Example:
```
<?php
use GenesisGlobal\Optimove\Client;

$username = 'foo';
$password = 'password';
$client = new Client($username, $password);

$promotions = $client->promotions();
```

### General
To retrieve `General` object you should call method `general()` from `Client` object.

#### login(string $username, string $password)
Method login `Client` to Optimove API. This method is auto executed durning creating `Client` instance.

##### Parameters
- string `$username` - Optimove account username
- string `$password` - Optimove account password
 
##### Example:
```
<?php
use GenesisGlobal\Optimove\Client;

$username = 'foo';
$password = 'password';
$client = new Client($username, $password);

$newUser = 'bar';
$newPassword = 'secret';
$client->general()->login($newUser, $newPassword);
```

### Promotions
To retrieve `Promotions` object you need call method `promotions()` from `Client` object.

#### AddPromotions(array $promotions)
Adds promo codes and associated names that will be available for selection when running a campaign.
There is no need to worry about Optimove limit to sending promo coded.

If you will send more than 100 promocodes in one call then method will chunk your data and will send your data using several API calls.  

##### Parameters
* array `$promotions`
  Array of promotions, each promotions should be array which has following keys
    * PromoCode
    * PromotionName
  
##### Example:
```
<?php
use GenesisGlobal\Optimove\Client;

$username = 'foo';
$password = 'password';
$client = new Client($username, $password);

$promotions = [
  ["PromoCode" => "WB23", "PromotionName" => "Welcome back Promo"}],
  ["PromoCode" => "NV10", "PromotionName" => "New VIP 10% Discount"]
];
$client->promotions()->AddPromotions($promotions);
```

### GetPromotions()
Returns an array of all defined promo codes and associated names.

##### Parameters
None
  
##### Example:
```
<?php
use GenesisGlobal\Optimove\Client;

$username = 'foo';
$password = 'password';
$client = new Client($username, $password);

$promotions = $client->promotions()->GetPromotions();
```

#### DeletePromotions(array $promotions)
Removes previously-added promo codes.
There is no need to worry about Optimove limit to sending promo coded.

If you will send more than 100 promocodes in one call then method will chunk your data and will send your data using several API calls.  

##### Parameters
* array `$promotions`
  Array of promotions, each promotions should be array which has following keys
    * PromoCode
  
##### Example:
```
<?php
use GenesisGlobal\Optimove\Client;

$username = 'foo';
$password = 'password';
$client = new Client($username, $password);

$promotions = [
  ["PromoCode" => "WB23"],
  ["PromoCode" => "NV10"]
];
$client->promotions()->DeletePromotions($promotions);
```
