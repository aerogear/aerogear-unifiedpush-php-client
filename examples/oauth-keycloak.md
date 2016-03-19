
# KEYCLOAK PROVIDER for OAUTH 2

## Authorization flow

```php
<?php
$provider = new Stevenmaguire\OAuth2\Client\Provider\Keycloak(
  [
    'authServerUrl' => '{keycloak-server-url}',
    'realm'         => '{keycloak-realm}',
    'clientId'      => '{keycloak-client-id}',
    'clientSecret'  => '{keycloak-client-secret}',
    'redirectUri'   => 'https://example.com/callback-url',
  ]
);

if (!isset($_GET['code'])) {
    // If we don't have an authorization code then get one
    $authUrl                 = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state, make sure HTTP sessions are enabled.');

} else {
    // Try to get an access token (using the authorization coe grant)
    try {
        $token = $provider->getAccessToken(
          'authorization_code', [
          'code' => $_GET['code'],
        ]);
    } catch (Exception $e) {
        exit('Failed to get access token: '.$e->getMessage());
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```

## Refresh token
```php
$provider = new Stevenmaguire\OAuth2\Client\Provider\Keycloak([
    'authServerUrl'     => '{keycloak-server-url}',
    'realm'             => '{keycloak-realm}',
    'clientId'          => '{keycloak-client-id}',
    'clientSecret'      => '{keycloak-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

$token = $provider->getAccessToken('refresh_token', [
    'refresh_token' => $token->getRefreshToken(),
]);
```