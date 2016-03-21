<?php
/**
 * This file is part of the AeroGearPush package.
 *
 * (c) Napp <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Napp\AeroGearPush\Client;

use Napp\AeroGearPush\Exception\AeroGearAuthErrorException;
use Napp\AeroGearPush\Exception\AeroGearBadRequestException;
use Napp\AeroGearPush\Exception\AeroGearNotFoundException;
use Napp\AeroGearPush\Exception\AeroGearPushException;

/**
 * Class DummyClient
 *
 * Usage only for PHPUnit tests.
 *
 * @package Napp\AeroGearPush\Client
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class DummyClient
{

    /**
     * @var array
     */
    protected $endpoints = [
      'applications',
      'applications/create',
      'applications/6d917118',
      'applications/6d917118/android',
      'applications/6d917118/delete',
      'applications/6d917118/ios',
      'applications/6d917118/installations',
      'applications/6d917118/simplePush',
      'applications/6d917118/update',
      'metrics/dashboard',
      'metrics/dashboard/active',
      'metrics/dashboard/warnings',
      'metrics/messages/application/6d917118',
      'sender',
      'sys/info/health',
    ];

    /**
     * @param       $method
     * @param       $url
     * @param       $endpoint
     * @param       $auth
     * @param       $data
     * @param array $options
     *
     * @return mixed
     * @throws \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     * @throws \Napp\AeroGearPush\Exception\AeroGearBadRequestException
     * @throws \Napp\AeroGearPush\Exception\AeroGearNotFoundException
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function call($method, $url, $endpoint, $auth, $data, $options = [])
    {
        $queryParams = null;

        // Parse query parameters.
        if (!empty($options['queryParam']) && is_array($options['queryParam'])) {
            $endpoint = rtrim($endpoint, '/');
            $endpoint .= '/?'.$queryParams = http_build_query(
                $options['queryParam']
              );
        }

        // Parse the headers array.
        if (!empty($data['headers'])) {
            $headers = $data['headers']['headers'];
            unset($data['headers']);
        }

        // Set Authorization Bearer if a Oauth token is available.
        if (isset($options['OAuthToken'])) {
            $headers['Authorization'] = 'Bearer '.$options['OAuthToken'];
            // If Authorization bearer is avail, disable auth.
            $auth = [];
        }

        // Set datatype, wheather it's a file upload or json
        if (isset($data['certificate'])) {
            $dataType = 'multipart';
            foreach ($data as $key => $value) {
                $data[] = [
                  'name'     => $key,
                  'contents' => $value,
                ];
                unset($data[$key]);
            }
        } else {
            $dataType                = 'json';
            $headers['Content-Type'] = 'application/json';
        }

        try {
            $response = $this->request(
              $method,
              $url.$endpoint,
              [
                'debug'       => false,
                'http_errors' => true,
                'verify'      => isset($options['verifySSL']) ? $options['verifySSL'] : true,
                $dataType     => $data,
                'auth'        => $auth,
                'headers'     => $headers,
              ]
            );

            return $response;
        } catch (ClientException $e) {
            switch ($e->getCode()) {
                case 400:
                case 415:
                    throw new AeroGearBadRequestException($e->getMessage(), $e->getCode());
                case 401:
                    throw new AeroGearAuthErrorException($e->getMessage(), $e->getCode());
                case 404:
                    throw new AeroGearNotFoundException($e->getMessage(), $e->getCode());
                case 500:
                    throw new AeroGearPushException($e->getMessage(), $e->getCode());
            }
        }
    }

    /**
     * @param       $method
     * @param       $url
     * @param array $data
     *
     * @return mixed
     */
    public function request($method, $url, $data = [])
    {
        foreach ($this->endpoints as $endpoint) {
            if (strpos($url, $endpoint)) {
                $endpoint       = str_replace('/', ' ', $endpoint);
                $endpointMethod = strtolower($method).str_replace(' ', '', ucwords($endpoint));
            }
        }

        $response = $this->$endpointMethod();

        return $response;
    }

    /**
     * Create POST response sender/
     *
     * @return string
     */
    public function postSender()
    {
        return '{}';
    }

    /**
     * Create POST response applications/
     *
     * @return string
     */
    public function postApplications()
    {
        return '{
  "id": "3aad1e92-3255-461b-8129-854025a5e7ab",
  "name": "Im testing an app",
  "description": "With some kind of description",
  "pushApplicationID": "dc5df3f3-2609-4547-9cc5-a844fc3b09e3",
  "masterSecret": "3faf2c75-72eb-4fc1-bc01-edb3206ec58b",
  "developer": "user",
  "variants": []
}';
    }

    /**
     * Create GET response applications/6d917118/installations
     *
     * @return string
     */
    public function getApplications6d917118Installations()
    {
        return '';
    }

    /**
     * Create GET response applications/
     *
     * @return string
     */
    public function getApplications()
    {
        return '[{
  "id": "9843a2b0-13b5-4ae4-8454-7078f5be766d",
  "name": "An App",
  "description": null,
  "pushApplicationID": "6d917118",
  "masterSecret": "09642680-a076-4ec8-928a-4d1ca0d4b5f3",
  "developer": "user",
  "variants": []
}, {
  "id": "aff426d1-06c7-49cb-92d4-3e8ed8895100",
  "name": "Testing an app",
  "description": "This is a description for the app",
  "pushApplicationID": "1583a48d-3f4e-4e9b-b864-ee6570068cf6",
  "masterSecret": "e36a3300-0c0c-4708-9676-061478581af1",
  "developer": "user",
  "variants": [{
    "id": "3447af97-c196-4545-8229-accd3bccd240",
    "name": "An android variant",
    "description": "And a description on the variant",
    "variantID": "8679eeb3-8b55-4f8f-801b-24d09cdb03ee",
    "secret": "0cf65734-4a5b-4ef1-82ec-64a5836f9d69",
    "developer": "user",
    "googleKey": "{GOOGLE_KEY}",
    "projectNumber": null,
    "type": "android"
  }]
}, {
  "id": "eff9e430-c84b-4e2a-bb72-0a04bfd4dde7",
  "name": "Im testing another app",
  "description": "With a description",
  "pushApplicationID": "7aa0320d-5897-426a-b67b-02e57be76037",
  "masterSecret": "19148d71-5748-4f78-a681-dbc1db5ffd05",
  "developer": "user",
  "variants": []
}, {
  "id": "fb70fe36-f2ed-4f50-babc-eab2fb8ba8b9",
  "name": "Yet another awesome app",
  "description": "42",
  "pushApplicationID": "0176e555-1ce6-463c-b454-3d7d3d5bcd71",
  "masterSecret": "8bb99312-0069-4fe3-971a-27c7e9f1b34c",
  "developer": "user",
  "variants": []
}]';
    }

    /**
     * Create POST response applications/6d917118/simplePush
     *
     * @return string
     */
    public function postApplications6d917118SimplePush()
    {
        return '{
  "id": "22debd80-04ab-4213-ac6f-18d6c0c106fe",
  "name": "A Simplepush variant",
  "description": "And a description on the variant",
  "variantID": "13f663bc-6321-4fc0-b8e1-77429d6c180c",
  "secret": "ed92f308-67ae-4315-b7d7-57b0c206574d",
  "developer": "user",
  "production": false,
  "type": "simplePush"
}';
    }

    /**
     * Create POST response applications/6d917118/ios
     *
     * @return string
     */
    public function postApplications6d917118Ios()
    {
        return '{
  "id": "22debd80-04ab-4213-ac6f-18d6c0c106fe",
  "name": "An ios variant",
  "description": "And a description on the variant",
  "variantID": "13f663bc-6321-4fc0-b8e1-77429d6c180c",
  "secret": "ed92f308-67ae-4315-b7d7-57b0c206574d",
  "developer": "user",
  "production": false,
  "type": "ios"
}';
    }

    /**
     * Create POST response applications/6d917118/android
     *
     * @return string
     */
    public function postApplications6d917118Android()
    {
        return '{
  "id": "a69d2e3f-1447-4bfc-b355-42439e2c2ab9",
  "name": "An android variant",
  "description": "And a description on the variant",
  "variantID": "a6d35fa9-8ed4-459d-a1f9-c8d0a3c9c34f",
  "secret": "7bbabf24-fd99-4dd2-aff5-f2e2bd0e8ec1",
  "developer": "user",
  "googleKey": "{GOOGLE_KEY}",
  "projectNumber": null,
  "type": "android"
}';
    }

    /**
     * Create GET response metrics/messages/applications/6d917118
     *
     * @return string
     */
    public function getMetricsMessagesApplication6d917118()
    {
        return '';
    }

    /**
     * Create DELETE response application/6d917118
     *
     * @return string
     */
    public function deleteApplications6d917118()
    {
        return '';
    }

    /**
     * Dummy PUT response applications/6d917118
     *
     * @return string
     */
    public function putApplications6d917118()
    {
        return '';
    }

    /**
     * Create GET response applications/6d917118 endpoint
     *
     * @return string
     */
    public function getApplications6d917118()
    {
        return '{
  "id": "9843a2b0-13b5-4ae4-8454-7078f5be766d",
  "name": "An App",
  "description": null,
  "pushApplicationID": "6d917118",
  "masterSecret": "09642680-a076-4ec8-928a-4d1ca0d4b5f3",
  "developer": "user",
  "variants": []
}';
    }

    /**
     * Create GET response from metrics/dashboard endpoint.
     *
     * @return mixed
     */
    public function getMetricsDashboard()
    {
        $returns = [
          'applications' => 4,
          'devices'      => 3,
          'messages'     => 2,
        ];

        return json_encode($returns);
    }

    /**
     * Create GET response from metrics/dashboard/active endpoint.
     *
     * @return mixed
     */
    public function getMetricsDashboardActive()
    {
        $returns = [];

        return json_encode($returns);
    }

    /**
     * Create GET response from metrics/dashboard/warnings endpoint.
     *
     * @return mixed
     */
    public function getMetricsDashboardWarnings()
    {
        $returns = [];

        return json_encode($returns);
    }

    /**
     * Create GET response from sys/info/health endpoint.
     *
     * @return mixed
     */
    public function getSysInfoHealth()
    {
        $returns = [
          'status'  => 'ok',
          'details' => [
            [
              'runtime'     => 7,
              'result'      => 'connected',
              'description' => 'Database connection',
              'test_status' => 'ok',
            ],
            [
              'runtime'     => 22,
              'result'      => 'online',
              'description' => 'Google Cloud Messaging',
              'test_status' => 'ok',
            ],
            [
              'runtime'     => 2,
              'result'      => 'online',
              'description' => 'Apple Push Network Sandbox',
              'test_status' => 'ok',
            ],
            [
              'runtime'     => 13,
              'result'      => 'online',
              'description' => 'Apple Push Network Production',
              'test_status' => 'ok',
            ],
            [
              'runtime'     => 100,
              'result'      => 'online',
              'description' => 'Windows Push Network',
              'test_status' => 'ok',
            ],
          ],
          'summary' => 'Everything is ok',
        ];

        return json_encode($returns);
    }
}
