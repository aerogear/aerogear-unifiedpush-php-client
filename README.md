# AeroGearPush
A library which intgrates with the the [Redhat Aerogear Unified Push](https://aerogear.org/push/) restful API.


## Installation
### Composer

    $ composer require napp/aero-gear-push


## Usage

Example on how to use this library.

```php
<?php

use Napp\Request;
use Napp\Exception;

$request = new senderPushRequest();
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
  $response = $client->senderPush($request);
  var_dump($response);
} catch (AeroGearPushException $e) {
  die($e->getMessage());
}
```

## Available Request/Response methods.

For information about how to format the single methods which is accepting arrays, please take a look at the
 [AeroGear Unified Push API documentation](https://aerogear.org/docs/specs/aerogear-unifiedpush-rest/).

#### createApplicationRequest()
##### Required methods
```setBearer() # oAuth token```
```setName() # string```

##### Optional methods
```setDeveloper() # string```
```setDescription() # string```

##### Response
The response is handled by ```createApplication($request)```

##### Return type
json


#### updateApplicationRequest()
##### Required methods
```setBearer() # oAuth token```
```setName() # string```

##### Optional methods
```setDeveloper() # string```
```setDescription() # string```

##### Response
The response is handled by ```createApplication()```

##### Return type
json


#### deleteApplicationRequest($pushAppId)
##### Required methods
```setBearer() # oAuth token```

##### Optional methods

##### Response
The response is handled by ```deleteApplication()```

##### Return type
json


#### createIosVariantRequest($pushAppId)
##### Required methods
```setBearer() # oAuth token```
```setCertificate() # fopen file resource```
```setPassphrase() # string```
```setProduction() # boolean```

##### Optional methods
```setName() # string```
```setDescription() # string```
```setDeveloper() # string```

##### Response
The reponse is handled by ```createIosVariant($request)```

##### Return type
json


#### createSimplePushVariantRequest($pushAppId)
##### Required methods
```setBearer() # oAuth token```

##### Optional methods
```setName() # string```
```setDescription() # string```
```setDeveloper() # string```
```setProjectNumber() # string```

##### Response
The response is handled by ```createSimplePushVariant()```

##### Return type
json


#### createAndroidVariantRequest($pushAppId)
##### Required methods
```setBearer() # oAuth token```
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


#### senderPushRequest()
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


#### getApplicationInstallationRequest()
##### Required methods
```setBearer() # oAuth token```
```setVariantId() # string```

##### Optional methods
```setInstallationId() # string```

##### Response
The response is handled by ```getApplicationInstallation()```

##### Return type
json


#### getApplicationRequest()
##### Required methods
```setBearer() # oAuth token```

##### Optional methods
```setPageNumber() # integer```
```setPerPage() # integer```
```enableDeviceCount()```
```enableActivity()```

##### Response
The reponse is handled by ```getApplication()```

##### Return type
json


#### getMetricsMessagesRequest()
##### Required methods
```setBearer() # oAuth token```

##### Optional methods
```setPageNumber() # integer```
```setPerPage() # integer```

##### Response
The response is handled by '''metricsMessages()```

##### Return type
json


#### getMetricsDashboardRequest()
##### Required methods
```setBearer() # oAuth token```

##### Optional methods
```setType() # string {active, warnings}```

##### Response
The response is handled by ```metricsDashboard()```

##### Return type
json


#### getSysInfoHealthRequest()
##### Required methods
```setBearer() # oAuth token```

##### Optional methods

##### Response
The response is handled by ```sysInfoHealth()```

##### Return type
json



## License
MIT, see LICENSE.
