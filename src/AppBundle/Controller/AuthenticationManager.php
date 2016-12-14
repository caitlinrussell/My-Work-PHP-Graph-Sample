<?php

namespace AppBundle\Controller;

class AuthenticationManager
{
	/**
	* Fetch the access code to start authentication. This is needed before fetching the user's access token
	*/
	public static function connect()
	{
		$redirect = Constants::AUTHORITY_URL . Constants::AUTHORIZE_ENDPOINT .
					'?response_type=code' .
					'&client_id=' . urlencode(Constants::CLIENT_ID) .
					'&redirect_uri=' . urlencode(Constants::REDIRECT_URI);

		//Redirect to Microsoft login
		header("Location: {$redirect}");
		exit();
	}

	/**
	* Acquire access token for current user. Requires response code to be saved in session
	*/
	public static function acquireToken()
	{
		$tokenEndpoint = Constants::AUTHORITY_URL . Constants::TOKEN_ENDPOINT;
		$response = RequestManager::sendPostRequest(
			$tokenEndpoint,
			array(),
			array(
				'client_id' => Constants::CLIENT_ID,
				'client_secret' => Constants::CLIENT_SECRET,
				'code' => $_SESSION['code'],
				'grant_type' => 'authorization_code',
				'redirect_uri' => Constants::REDIRECT_URI,
				'resource' => Constants::RESOURCE_ID
			)
		);

		$jsonResponse = json_decode($response, true);

		/*
		* Save the response variables in the session. This includes data such as user ID, name, 
		* and email, as well as the access token
		*/
		foreach ($jsonResponse as $key => $value) {
			$_SESSION[$key] = $value;
		}

		//Decode the JWT token with user info
		$decodedAccessTokenPayload = base64_decode(
			explode('.', $_SESSION['id_token'])[1]
		);
		$jsonAccessTokenPayload = json_decode($decodedAccessTokenPayload, true);

		foreach ($jsonAccessTokenPayload as $key => $value) {
			$_SESSION[$key] = $value;
		}
	}
}