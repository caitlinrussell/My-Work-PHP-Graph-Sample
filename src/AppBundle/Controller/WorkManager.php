<?php
namespace AppBundle\Controller;

class WorkManager
{
	/**
	* Get a given user's work items
	* @param string $user An email address or ID of a user in the logged-in user's group
	* @param EntityDoctrine $em An entity doctrine to access the database
	*
	* @return array(array(string, string, string, array(string, string))) A list of work items with created at timestamp, avatar, name, and associated file title and icon image
	*/
	public static function getWorkItems($user, $em)
	{
		$workItems = $em
			->getRepository('AppBundle:WorkItem')
			->findBy(array('user' => $user, 'status' => 'active'), array('created_at' => 'desc'));

		foreach ($workItems as $item)
		{
			$item->createdAt = $item->getCreatedAt()->format('M j g:i a'); //Convert from datetime to string
			$item->avatar = PersonManager::getAvatar($user);
			$item->name = PersonManager::getName($user);
			$fileIcon = WorkManager::getFileIcon($item->getFileType());
			
			$item->associatedFile = array('title' => $item->getDocTitle(), 'image' => $fileIcon);
		}

		return $workItems;
	}

	/**
	* Get a list of the team's work items, one per person
	* @param string $user An email address or ID of a user in the logged-in user's group
	* @param EntityDoctrine $em An entity doctrine to access the database
	*
	* @return array(array(string, string, string, array(string, string))) A list of work items with created at timestamp, avatar, name, and associated file title and icon image
	*/
	public static function getTeamWorkItems($user, $em)
	{
		$team = PersonManager::getTeammates($user);

		$teamWorkItems = array();
		foreach ($team as $teammate) 
		{
			//For now, let's just return the most recent work item
			$latestWorkItem = WorkManager::getWorkItems($teammate, $em)[0];
			if ($latestWorkItem != null)
				$teamWorkItems[] = $latestWorkItem;
		}
		return $teamWorkItems;
	}

	/**
	* Get the matching file icon for a given file type
	* @param string $fileType The extension of the file
	*
	* @return string $fileIcon The image file associated with the given file type
	*/
	public static function getFileIcon($fileType)
	{
		switch($fileType) {
			case 'docx' : 
				$fileIcon = "word.jpg";
				break;
			case 'xlsx' :
				$fileIcon = "excel.jpg";
				break;
			case 'one' :
				$fileIcon = "onenote.jpg";
				break;
			case 'pptx' :
				$fileIcon = "powerpoint.jpg";
				break;
		}
		return $fileIcon;
	}
}