# My-Work-PHP-Graph-Sample

This MS Graph API sample demonstrates using Graph's REST API to query for data about a user, his team, and his documents. This project leverages the Symfony PHP framework to create a simple web app for users to navigate their work items.

My Work allows a team to stay up-to-date on what their teammates are working on and the documents they are using. When a user logs in, she is prompted to enter a work item and has the opportunity to link recent OneDrive documents to the task. She can also see what other people on her team are working on.

![My Work dashboard screenshot](https://github.com/cbales/My-Work-PHP-Graph-Sample/blob/master/screenshots/dashboard.PNG)

### Requirements
1. An Office365 account
2. [XAMPP](https://www.apachefriends.org/index.html) installed (or equivalent apache server setup with mysql)

### Running the Sample
1. Clone or download the sample from Github
2. Copy into your local XAMPP installation or remote web host
3. Register your app at [apps.dev.microsoft.com](https://apps.dev.microsoft.com)
4. Update your client credentials in src > AppBundle > Controller> Constants.php
5. Enable https on your server on port 8003
6. Start up your server


### About the Sample
To learn more about Graph and accessing the API in your own apps, go to [graph.microsoft.io](https://graph.microsoft.io/en-us/)

To use command line tools and access other goodies built in to Symfony, it's recommended that you [install Symfony](http://symfony.com/doc/current/book/installation.html)
