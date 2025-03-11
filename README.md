# Active Campaign v3 PHP Wrapper

Unofficial PHP Wrapper for ActiveCampaign API v3.

## Installation:
```shell
composer require jetimob/activecampaign-v3-php
```

## Basic usage:
#### Create a client:

```php
$gClient   = Client::buildGuzzleClient($api_url, $api_token);
$gTracking = Client::buildTrackingGuzzleClient($event_tracking_actid, $event_tracking_key);

$client = new Client($gClient, $gTracking);
```

#### Select Contacts endpoint:
```php
$contacts = new Contacts($client);
```

#### Create new contact:
```php
$contact = $contacts->create([
    'email'     => 'CONTACT_EMAIL',
    'firstName' => 'CONTACT_FIRST_NAME',
    'lastName'  => 'CONTACT_LAST_NAME',
]);
```


## Available endpoints:
* Contacts
* Deals
* Lists
* Organizations
* EventTracking
* SiteTracking

## ActiveCampaign Developer Documentation
Official API docs: https://developers.activecampaign.com/reference

