# AeroGearPush

A library which integrates with the the [Redhat Aerogear Unified Push](https://aerogear.org/push/) restful API.


## Installation

### Composer

    $ composer require napp/aero-gear-push


## Keycloak oauth token usage

All, but SenderPushRequest(), have a OAuthToken dependency, and to generate the token, look in examples/oauth-keycloak.md

An example on how to set the token.

```php
$request->setOauthToken($token);
```



## Usage

Example on how to use this library.

```php
<?php

use Napp\AeroGearPush;
use Napp\AeroGearPush\Request;
use Napp\AeroGearPush\Exception;

$client = new AeroGearPush('https://host.com/ag-push/rest/');

$request = new SenderPushRequest();
$request
->setAuth('PushApplicationID', 'MasterSecret')
->setMessage(
  [
    'sound' => 'default',
    'alert' => 'this is a message.',
  ]
)
->setCriteria(
  [
    'alias' => ['my-alias'],
  ]
);

try {
  $response = $client->SenderPush($request);
  var_dump($response);
} catch (AeroGearPushException $e) {
  die($e->getMessage());
}
```

## Available Request/Response methods.

For information about how to format the single methods which is accepting arrays, please take a look at the
 [AeroGear Unified Push API documentation](https://aerogear.org/docs/specs/aerogear-unifiedpush-rest/).

#### CreateApplicationRequest()
##### Required methods
```setOauthToken() # oAuth token```
```setName() # string```

##### Optional methods
```setDeveloper() # string```
```setDescription() # string```

##### Response
The response is handled by ```createApplication($request)```

##### Return type
json


#### UpdateApplicationRequest()
##### Required methods
```setOauthToken() # oAuth token```
```setName() # string```

##### Optional methods
```setDeveloper() # string```
```setDescription() # string```

##### Response
The response is handled by ```createApplication()```

##### Return type
json


#### DeleteApplicationRequest($pushAppId)
##### Required methods
```setOauthToken() # oAuth token```

##### Optional methods

##### Response
The response is handled by ```deleteApplication()```

##### Return type
json


#### CreateIosVariantRequest($pushAppId)
##### Required methods
```setOauthToken() # oAuth token```
```setCertificate() # fopen file resource```
```setPassphrase() # string```
```setProduction() # string ('true' or 'false')'```

##### Optional methods
```setName() # string```
```setDescription() # string```
```setDeveloper() # string```

##### Response
The reponse is handled by ```createIosVariant($request)```

##### Return type
json


#### CreateSimplePushVariantRequest($pushAppId)
##### Required methods
```setOauthToken() # oAuth token```

##### Optional methods
```setName() # string```
```setDescription() # string```
```setDeveloper() # string```
```setProjectNumber() # string```

##### Response
The response is handled by ```createSimplePushVariant()```

##### Return type
json


#### CreateAndroidVariantRequest($pushAppId)
##### Required methods
```setOauthToken() # oAuth token```
```setGoogleKey() # string```

##### Optional methods
```setName() # string```
```setDescription() # string```
```setDeveloper() # string```
```setProjectNumber() # string```

##### Response
The response is handled by ```createAndroidVariant()```

##### Return type
json


#### SenderPushRequest()
[Aerogear Unified Push documentation](https://aerogear.org/docs/specs/aerogear-unifiedpush-rest/#397083935)

##### Required methods
```setAuth(pushApplicationId, masterSecret)```
```setMessage() # array```
```setCriteria() # array```

##### Optional methods
```setConfig() # array```

##### Response
The response is handled by ```senderPush()```

##### Return type
json


#### GetApplicationInstallationRequest()
##### Required methods
```setOauthToken() # oAuth token```
```setVariantId() # string```

##### Optional methods
```setInstallationId() # string```

##### Response
The response is handled by ```getApplicationInstallation()```

##### Return type
json


#### GetApplicationRequest()
##### Required methods
```setOauthToken() # oAuth token```

##### Optional methods
```setPageNumber() # integer```
```setPerPage() # integer```
```enableDeviceCount()```
```enableActivity()```

##### Response
The reponse is handled by ```getApplication()```

##### Return type
json


#### GetMetricsMessagesRequest()
##### Required methods
```setOauthToken() # oAuth token```

##### Optional methods
```setPageNumber() # integer```
```setPerPage() # integer```

##### Response
The response is handled by '''metricsMessages()```

##### Return type
json


#### GetMetricsDashboardRequest()
##### Required methods
```setOauthToken() # oAuth token```

##### Optional methods
```setType() # string {active, warnings}```

##### Response
The response is handled by ```metricsDashboard()```

##### Return type
json


#### GetSysInfoHealthRequest()
##### Required methods
```setOauthToken() # oAuth token```

##### Optional methods

##### Response
The response is handled by ```sysInfoHealth()```

##### Return type
json



## License
MIT, see LICENSE.
