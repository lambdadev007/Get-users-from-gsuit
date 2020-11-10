<?php
require __DIR__ . '/vendor/autoload.php';

error_reporting(E_ERROR | E_PARSE);

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function setConfig() {
    $credentialsPath = './test123.json';
    $credentialsAvailable = false;
    
    $shortopts  = "";
    $longopts  = array(
        "cid:",
        "pid:",
        "csec:",
        "ruri:"
    );
    
    $options = getopt($shortopts, $longopts);
    
    if(!file_exists($credentialsPath) && count($options) < 4 ) {
        print("You must specify the app credentials!");
        die;
    }
    
    if(!!$options['cid'] && !!$options['pid'] && !!$options['csec'] && !!$options['ruri']) {
        $credentials = [
            "web" => [
                "client_id" => $options['cid'],
                "project_id" => $options['pid'],
                "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                "token_uri" => "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                "client_secret" => $options['csec'],
                "redirect_uris" => [
                    $options['ruri']
                ]
            ]
        ];
    
        file_put_contents($credentialsPath, json_encode($credentials));
        $credentialsAvailable = true;
    }
    else {
        if(file_exists($credentialsPath)) {
            $credentialsAvailable = true;
        }
    }
    
    if(!$credentialsAvailable) {
        print("You must specify the app credentials!");
        die;
    }

    return $credentialsPath;
}

function getClient($credentialsPath)
{
    $client = new Google_Client();
    $client->setApplicationName('G Suite Directory API PHP Quickstart');
    $client->setScopes(Google_Service_Directory::ADMIN_DIRECTORY_USER_READONLY);
    $client->setAuthConfig($credentialsPath);
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = './credentials.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
$cPath = setConfig();
$client = getClient($cPath);
$service = new Google_Service_Directory($client);

// Print the first 10 users in the domain.
$optParams = array(
  'customer' => 'my_customer',
//   'maxResults' => 10,
  'orderBy' => 'email',
);
$results = $service->users->listUsers($optParams);

$directory = "./results";
if (!file_exists($directory)) {
    mkdir($directory, 0777, true);
}

$fileName = "users-".time().".csv";
$file = fopen($directory. "/" . $fileName, "w");
$header = ['FIRSTNAME', 'LASTNAME', 'EMAIL', 'OrganizationalUnit'];
fputcsv($file, $header);
$numberOfUsers = 0;

if (count($results->getUsers()) == 0) {
  print "No users found.\n";
} else {
  foreach ($results->getUsers() as $user) {
    // print_r($user);

    $email = $user->getPrimaryEmail();
    $domain = '';

    if($email && $email !== '' && count(explode('@', $email)) > 1)
        $domain = explode('@', $email)[1];

    $name = $user->getName()->getFullName();
    $fName = '';
    $lName='';
    if($name && $name !== '')
        $fName = explode(' ', $name)[0];
    if($name && $name !== '' && count(explode(' ', $name)) > 1)
        $lName = explode(' ', $name)[1];

    $orgUnit = $domain.$user->orgUnitPath;

    fputcsv($file, [$fName, $lName, $email, $orgUnit]);

    $numberOfUsers++;
    // printf("%s (%s %s) %s\n", $email, $fName, $lName, $domain.$orgUnit);
  }

  printf("[%s] %s users have been exported, You can view the file in the results directory!\n", $fileName, $numberOfUsers);
}

fclose($file);