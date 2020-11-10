# Get Users from G-suit

## Prerequisites

### Enable Directory API for your project

Any application that calls Google APIs needs to enable those APIs in the API Console. To enable the appropriate APIs for your project:

1.  Open the [Library](https://console.developers.google.com/apis/library) page in the API Console.
2.  Select the project associated with your application. Create a project if you do not have one already.
3.  Use the **Library** page to find each API that your application will use. Click on each API and enable it for your project.

### Create authorization credentials

Any application that uses OAuth 2.0 to access Google APIs must have authorization credentials that identify the application to Google's OAuth 2.0 server. The following steps explain how to create credentials for your project. Your applications can then use the credentials to access APIs that you have enabled for that project.

1.  Open the [Credentials page](https://console.developers.google.com/apis/credentials) in the API Console.
2.  Click **Create credentials > OAuth client ID**.
3.  Complete the form. Set the application type to `Web application`. The redirect URIs are the endpoints to which the OAuth 2.0 server can send responses.

    For testing, you can specify URIs that refer to the local machine, such as `http://localhost:8080`.

After creating your credentials, download the **client_secret.json** file from the API Console. Securely store the file in a location


## Setup
- Clone this repository by running below command
  
  ``git clone https://github.com/lambdadev007/Get-users-from-gsuit.git``
- Run `composer install`

## How it works
- Move to the project directory and Run
  
  ``php getUser.php --cid=<client_id> --pid=<project_id> --csec=<client_secret> --ruri=<redirect_uri>``

  > FYI: As far as you use same app credentials, you won't need to specficy the parameters for future.

- You will be prompted to authroize access to your G-suit account.
- Upon allowing access, you will be redirected to the app URL which you added while you create the Oauth credentials.
- On the app page, copy the authorization code and paste to the terminal.
- It would generate a csv file that contains user list in the results directory.