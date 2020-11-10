# Get-Users-from-G-suit

## 1. Setup
- Clone this repository by running below command
  
  `git clone https://github.com/lambdadev007/Get-Users-from-G-suit.git`
- Run `composer install`
- Create a Oauth credentials and enable Directory API on your Google account.
- Down load credentials and save it in the project directory as named  `credentials.json`

## 2. How it works
- Move to the project directory and Run
  
  `php getUser.php`

- You will be prompted to authroize access to your G-suit account.
- Upon allowing access, you will be redirected to the app URL which you added while you create the Oauth credentials.
- On the app page, copy the authorization code and paste to the terminal.