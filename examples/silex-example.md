```php

<?php

$loader = require __DIR__.'/../vendor/autoload.php';

$app    = new \Silex\Application();
$app->register(new \Silex\Provider\SessionServiceProvider());

$app['keycloak'] = [
    'authServerUrl' => '{keycloak-server-url}',
    'realm'         => '{keycloak-realm}',
    'clientId'      => '{keycloak-client-id}',
    'clientSecret'  => '{keycloak-client-secret}',
    'redirectUri'   => 'https://example.com/callback-url',
];

$client       = new \Napp\AeroGearPush\AeroGearPush(
  'https://aerogear-testhost.rhcloud.com/ag-push/rest/', [
    'verifySSL' => true,
  ]
);

$app['token'] = $app['session']->get('token');

$app->get(
  '/send',
  function () use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\SenderPushRequest();
      $request
        ->setAuth('3014-434a-bf6f-1a52473004cb', 'b6dd-49da-abcb-0ea01f0ced43')
        ->setMessage(
          [
            'sound' => 'default',
            'alert' => 'this is a push message',
          ]
        )
        ->setCriteria(
          [
            'alias' => ['my-alias'],
          ]
        );

      try {
          $response = $client->senderPush($request);

          return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      }
  }
);

$app->get(
  'applications/{pushAppId}/simplepush',
  function ($pushAppId) use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\CreateSimplePushVariantRequest($pushAppId);
      $request
        ->setOauthToken($app['token'])
        ->setName('A simplepush variant')
        ->setDescription('Some description');

      try {
          $response = $client->createSimplePushVariant($request);

          return new \Symfony\Component\HttpFoundation\JsonResponse([$response]);
      } catch (\Napp\AeroGearPush\Exception\AeroGearNotFoundException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearBadRequestException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      }
  }
);

$app->get(
  'applications/{pushAppId}/ios',
  function ($pushAppId) use ($app, $client) {
      $file = (
      '/Users/hasse/www/napp/aerogear/web/Certificates.p12');

      $request = new \Napp\AeroGearPush\Request\CreateIosVariantRequest($pushAppId);

      $request
        ->setOauthToken($app['token'])
        ->setName('A ios variant')
        ->setCertificate(fopen($file, 'r'))
        ->setProduction('false')
        ->setPassphrase('TEST_PASSCODE_ON_CERTIFICATE')
        ->setDescription('Some description');

      try {
          $response = $client->createIosVariant($request);

          return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
      } catch (\Napp\AeroGearPush\Exception\AeroGearNotFoundException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearBadRequestException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      }

  }
);


$app->get(
  'applications/{pushAppId}/android',
  function ($pushAppId) use ($app, $client) {

      $request = new \Napp\AeroGearPush\Request\CreateAndroidVariantRequest($pushAppId);
      $request
        ->setOauthToken($app['token'])
        ->setName('An android variant')
        ->setDescription('Some description')
        ->setGoogleKey('GOOGLE_KEY');

      try {
          $response = $client->createAndroidVariant($request);

          return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
      } catch (\Napp\AeroGearPush\Exception\AeroGearNotFoundException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearBadRequestException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      }
  }
);

$app->get(
  '/applications/create',
  function () use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\CreateApplicationRequest();
      $request
        ->setOauthToken($app['token'])
        ->setName('Creating an app')
        ->setDescription('Some description');

      try {
          $response = $client->createApplication($request);

      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearBadRequestException $e) {
          die($e->getMessage());
      }

      return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
  }
);

$app->get(
  'applications/{pushAppId}/delete',
  function ($pushAppId) use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\DeleteApplicationRequest($pushAppId);
      $request->setOauthToken($app['token']);

      try {
          $response = $client->deleteApplication($request);

          return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearNotFoundException $e) {
          die($e->getMessage());
      }
  }
);

$app->get(
  'applications/{pushAppId}/update',
  function ($pushAppId) use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\UpdateApplicationRequest($pushAppId);
      $request
        ->setOauthToken($app['token'])
        ->setName('New app name '.uniqid());

      try {
          $response = $client->createApplication($request);

          return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearNotFoundException $e) {
          die($e->getMessage());
      }
  }
);

$app->get(
  'applications/{variantId}/installations/{installationId}',
  function ($variantId, $installationId = null) use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\GetApplicationInstallationRequest();
      $request
        ->setOauthToken($app['token'])
        ->setVariantId($variantId);

      if (true == $installationId) {
          $request->setInstallationId($installationId);
      }

      try {
          $response = $client->getApplicationInstallation($request);

          return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearNotFoundException $e) {
          die($e->getMessage());
      }

  }
)->assert('installationId', '.*');

$app->get(
  'applications/{pushAppId}',
  function ($pushAppId) use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\GetApplicationRequest($pushAppId);
      $request
        ->setOauthToken($app['token'])
        ->setPageNumber(0)
        ->setPerPage(10)
        ->enableDeviceCount()
        ->enableActivity();

      try {
          $response = $client->getApplication($request);

          return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearNotFoundException $e) {
          die($e->getMessage());
      }

  }
)->assert('pushAppId', '.*');


$app->get(
  'metrics/messages/application/{pushAppId}',
  function ($pushAppId) use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\GetMetricsMessagesRequest($pushAppId);
      $request
        ->setOauthToken($app['token'])
        ->setPerPage(10)
        ->setPageNumber(0);

      try {
          $response = $client->metricsMessages($request);

          return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearNotFoundException $e) {
          die($e->getMessage());
      }
  }
);

$app->get(
  'metrics/dashboard/{type}',
  function ($type) use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\GetMetricsDashboardRequest();
      $request->setOauthToken($app['token']);

      try {
          $response = $client->metricsDashboard($request);

          return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearNotFoundException $e) {
          die($e->getMessage());
      }
  }
)->assert('type', '.*');

$app->get(
  '/health',
  function () use ($app, $client) {
      $request = new \Napp\AeroGearPush\Request\GetSysInfoHealthRequest();
      $request->setOauthToken($app['token']);

      try {
          $response = $client->sysInfoHealth($request);
      } catch (\Napp\AeroGearPush\Exception\AeroGearMissingOAuthTokenException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearAuthErrorException $e) {
          die($e->getMessage());
      } catch (\Napp\AeroGearPush\Exception\AeroGearPushException $e) {
          die($e->getMessage());
      }

      return new \Symfony\Component\HttpFoundation\Response($response, 200, ['Content-Type' => 'application/json']);
  }
);


// oAuth stuff
$app->get(
  '/token',
  function () use ($app) {
      return new \Symfony\Component\HttpFoundation\Response($app['session']->get('token'));
  }
);
$app->get(
  '/login',
  function () use ($app) {
      $provider = new \Stevenmaguire\OAuth2\Client\Provider\Keycloak($app['keycloak']);
      if (!isset($_GET['code'])) {
          // If we don't have an authorization code then get one
          $authUrl                 = $provider->getAuthorizationUrl();
          $app['session']->set('oauth2state' ,$provider->getState());
          header('Location: '.$authUrl);
          exit;

          // Check given state against previously stored one to mitigate CSRF attack
      } elseif (empty($_GET['state']) || ($_GET['state'] !== $app['session']->get('oauth2state'))
      ) {
          exit('Invalid state, make sure HTTP sessions are enabled.');
      } else {

          // Try to get an access token (using the authorization coe grant)
          try {
              $token = $provider->getAccessToken(
                'authorization_code',
                [
                  'code' => $_GET['code'],
                ]
              );
          } catch (Exception $e) {
              exit('Failed to get access token: '.$e->getMessage());
          }

          // Optional: Now you have a token you can look up a users profile data
          try {

              // We got an access token, let's now get the user's details
              $user              = $provider->getResourceOwner($token);
              $app['session']->set('token', $token->getToken());


          } catch (Exception $e) {
              exit('Failed to get resource owner: '.$e->getMessage());
          }

          return new \Symfony\Component\HttpFoundation\Response(
            $token->getToken()
          );
      }
  }
);

$app->run();