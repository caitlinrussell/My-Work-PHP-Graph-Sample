<?php

namespace AppBundle\Controller;

class PersonManager
{
	/**
	* Get a given user's avatar
	* @param string $user An email address or ID of a user in the logged-in user's group
	*
	* @return A base64 encoded image
	*/
	public static function getAvatar($user)
	{
		$imageData = RequestManager::sendGetRequest(
			Constants::RESOURCE_ID . '/v1.0/users/' . $user . '/photo/$value',
			array(
				'Authorization: Bearer ' . $_SESSION['access_token'],
			)
		);
		return base64_encode($imageData);
	}

	/**
	* Get a list of the user's teammates
	* @param string $user An email address or ID of a user in the logged-in user's group
	*
	* @return array(string) An array of teammate emails
	*/
	public static function getTeammates($user)
	{
		//First, find the user's manager
		$manager = RequestManager::sendGetRequest(
			Constants::RESOURCE_ID . '/v1.0/me/manager',
			array(
				'Authorization: Bearer ' . $_SESSION['access_token']
			)
		);

		$manager = json_decode($manager, true);

		$teamArray = array();

		//Add the manager as a teammate
		$teamArray[] = $manager['mail'];

		//Now we can access the direct reports of the manager
		$directs = RequestManager::sendGetRequest(
			Constants::RESOURCE_ID . '/v1.0/users/'. $manager['id'] . '/directReports',
			array(
				'Authorization: Bearer ' . $_SESSION['access_token']
			)
		);

		$directs = json_decode($directs, true);

		//Add the direct reports as teammates (sanitized)
		foreach ($directs['value'] as $teammate) 
		{
			if ($teammate['mail'] != $user && $teammate['mail'] != '')
				$teamArray[] = $teammate['mail'];
		}
		return $teamArray;
	}

	/**
	* Get a given user's display name
	* @param string $user An email address or ID of a user in the logged-in user's group
	*
	* @return string The user's display name
	*/
	public static function getName($user)
	{
		$userData = RequestManager::sendGetRequest(
			Constants::RESOURCE_ID . '/v1.0/users/' . $user,
			array(
				'Authorization: Bearer ' . $_SESSION['access_token'],
			)
		);
		$userData = json_decode($userData, true);

		return $userData['displayName'];
	}

	/**
	* Get the logged in user's 4 most recent docs in OneDrive
	*
	* @return array(array(string, string, string, string)) A list of documents with file name, extension, id, and icon image
	*/
	public static function getRecentDocs()
	{
		$docs = RequestManager::sendGetRequest(
			Constants::RESOURCE_ID . '/v1.0/me/drive/recent?$top=4',
			array(
				'Authorization: Bearer ' . $_SESSION['access_token'],
			)
		);

		$docs = json_decode($docs, true);
		$recentDocs = array();

		foreach ($docs['value'] as $doc)
		{
			$fileName = explode('.', $doc['remoteItem']['name']);
			$fileIcon = WorkManager::getFileIcon($fileName[1]);

			$recentDocs[] = array('title' => $fileName[0], 'fileType' => $fileName[1], 'id' => $doc['id'], 'fileIcon' => $fileIcon);
		}
		return $recentDocs;
	}
}