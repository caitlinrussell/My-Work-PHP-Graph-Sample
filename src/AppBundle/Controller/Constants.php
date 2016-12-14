<?php

namespace AppBundle\Controller;

/**
* Stores configuration data for the app
*/
class Constants
{
	const CLIENT_ID = 'CLIENT_ID'; //Enter your client ID here
    const CLIENT_SECRET = 'CLIENT_SECRET'; //Enter your client secret here
    const REDIRECT_URI = 'https://localhost:8003/dashboard/callback';
    const AUTHORITY_URL = 'https://login.microsoftonline.com/common';
    const AUTHORIZE_ENDPOINT = '/oauth2/authorize';
    const TOKEN_ENDPOINT = '/oauth2/token';
    const LOGOUT_ENDPOINT = '/oauth2/logout';
    const RESOURCE_ID = 'https://graph.microsoft.com';
}