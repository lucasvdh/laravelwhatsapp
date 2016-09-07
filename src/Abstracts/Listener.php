<?php namespace Lucasvdh\LaravelWhatsapp\Abstracts;

use WhatsProt;
use Lucasvdh\LaravelWhatsapp\Interfaces\Listener as ListenerInterface;

abstract class Listener implements ListenerInterface
{
	protected $eventsToListenFor = [
		'onClose',
		'onCodeRegister',
		'onCodeRegisterFailed',
		'onCodeRequest',
		'onCodeRequestFailed',
		'onCodeRequestFailedTooRecent',
		'onConnect',
		'onConnectError',
		'onCredentialsBad',
		'onCredentialsGood',
		'onDisconnect',
		'onDissectPhone',
		'onDissectPhoneFailed',
		'onGetAudio',
		'onGetBroadcastLists',
		'onGetError',
		'onGetExtendAccount',
		'onGetGroupMessage',
		'onGetGroupParticipants',
		'onGetGroups',
		'onGetGroupsInfo',
		'onGetGroupsSubject',
		'onGetImage',
		'onGetLocation',
		'onGetMessage',
		'onGetNormalizedJid',
		'onGetPrivacyBlockedList',
		'onGetProfilePicture',
		'onGetReceipt',
		'onGetServerProperties',
		'onGetServicePricing',
		'onGetStatus',
		'onGetSyncResult',
		'onGetVideo',
		'onGetvCard',
		'onGroupCreate',
		'onGroupisCreated',
		'onGroupsChatCreate',
		'onGroupsChatEnd',
		'onGroupsParticipantsAdd',
		'onGroupsParticipantsPromote',
		'onGroupsParticipantsRemove',
		'onLoginFailed',
		'onLoginSuccess',
		'onAccountExpired',
		'onMediaMessageSent',
		'onMediaUploadFailed',
		'onMessageComposing',
		'onMessagePaused',
		'onMessageReceivedClient',
		'onMessageReceivedServer',
		'onPaidAccount',
		'onPing',
		'onPresenceAvailable',
		'onPresenceUnavailable',
		'onProfilePictureChanged',
		'onProfilePictureDeleted',
		'onSendMessage',
		'onSendMessageReceived',
		'onSendPong',
		'onSendPresence',
		'onSendStatusUpdate',
		'onStreamError',
		'onUploadFile',
		'onUploadFileFailed',
	];

	protected $connection;

	public function __construct(WhatsProt $connection)
	{
		$this->connection = $connection;
		return $this;
	}

	/**
	 * Register the events you want to listen for.
	 *
	 * @param array $eventList
	 *
	 * @return Listener
	 */
	public function setEventsToListenFor(array $eventList)
	{
		$this->eventsToListenFor = $eventList;
		return $this->startListening();
	}

	/**
	 * Binds the requested events to the event manager.
	 *
	 * @return $this
	 */
	protected function startListening()
	{
		foreach ($this->eventsToListenFor as $event) {
			if (is_callable([$this, $event])) {
				$this->connection->eventManager()->bind($event, [$this, $event]);
			}
		}
		return $this;
	}

	//Adding to this list? Please put them in alphabetical order!
	public function onCallReceived($phone_number, $from, $id, $notify, $time, $callId)
	{
	}

	public function onClose($phone_number, $error)
	{
	}

	public function onCodeRegister($phone_number, $login, $password, $type, $expiration, $kind, $price, $cost, $currency, $price_expiration)
	{
	}

	public function onCodeRegisterFailed($phone_number, $status, $reason, $retry_after)
	{
	}

	public function onCodeRequest($phone_number, $method, $length)
	{
	}

	public function onCodeRequestFailed($phone_number, $method, $reason, $param)
	{
	}

	public function onCodeRequestFailedTooRecent($phone_number, $method, $reason, $retry_after)
	{
	}

	public function onCodeRequestFailedTooManyGuesses($phone_number, $method, $reason, $retry_after)
	{
	}

	public function onConnect($phone_number, $socket)
	{
	}

	public function onConnectError($phone_number, $socket)
	{
	}

	public function onCredentialsBad($phone_number, $status, $reason)
	{
	}

	public function onCredentialsGood($phone_number, $login, $password, $type, $expiration, $kind, $price, $cost, $currency, $price_expiration)
	{
	}

	public function onDisconnect($phone_number, $socket)
	{
	}

	public function onDissectPhone($phone_number, $phonecountry, $phonecc, $phone, $phonemcc, $phoneISO3166, $phoneISO639, $phonemnc)
	{
	}

	public function onDissectPhoneFailed($phone_number)
	{
	}

	public function onGetAudio($phone_number, $from, $id, $type, $time, $name, $size, $url, $file, $mimeType, $fileHash, $duration, $acodec)
	{
	}

	public function onGetBroadcastLists($phone_number, $broadcastLists)
	{
	}

	public function onGetError($phone_number, $from, $id, $data, $errorType = null)
	{
	}

	public function onGetExtendAccount($phone_number, $kind, $status, $creation, $expiration)
	{
	}

	public function onGetFeature($phone_number, $from, $encrypt)
	{
	}

	public function onGetGroupMessage($phone_number, $from_group_jid, $from_user_jid, $id, $type, $time, $name, $body)
	{
	}

	public function onGetGroups($phone_number, $groupList)
	{
	}

	public function onGetGroupV2Info($phone_number, $group_id, $creator, $creation, $subject, $participants, $admins, $fromGetGroup)
	{
	}

	public function onGetGroupsSubject($phone_number, $group_jid, $time, $author, $name, $subject)
	{
	}

	public function onGetImage($phone_number, $from, $id, $type, $time, $name, $size, $url, $file, $mimeType, $fileHash, $width, $height, $preview, $caption)
	{
	}

	public function onGetGroupAudio($phone_number, $from_group_jid, $from_user_jid, $id, $type, $time, $name, $size, $url, $file, $mimeType, $fileHash, $duration, $acodec)
	{
	}

	public function onGetGroupImage($phone_number, $from_group_jid, $from_user_jid, $id, $type, $time, $name, $size, $url, $file, $mimeType, $fileHash, $width, $height, $preview, $caption)
	{
	}

	public function onGetGroupLocation($phone_number, $from_group_jid, $from_user_jid, $id, $type, $time, $name, $author, $longitude, $latitude, $url, $preview)
	{
	}

	public function onGetGroupVideo($phone_number, $from_group_jid, $from_user_jid, $id, $type, $time, $name, $url, $file, $size, $mimeType, $fileHash, $duration, $vcodec, $acodec, $preview, $caption)
	{
	}

	public function onGetGroupvCard($phone_number, $from_group_jid, $from_user_jid, $id, $type, $time, $name, $vcardname, $vcard)
	{
	}

	public function onGetLocation($phone_number, $from, $id, $type, $time, $name, $author, $longitude, $latitude, $url, $preview)
	{
	}

	public function onGetMessage($phone_number, $from, $id, $type, $time, $name, $body)
	{
	}

	public function onGetNormalizedJid($phone_number, $data)
	{
	}

	public function onGetPrivacyBlockedList($phone_number, $data)
	{
	}

	public function onGetProfilePicture($phone_number, $from, $type, $data)
	{
	}

	public function onGetReceipt($from, $id, $offline, $retry)
	{
	}

	public function onGetServerProperties($phone_number, $version, $props)
	{
	}

	public function onGetServicePricing($phone_number, $price, $cost, $currency, $expiration)
	{
	}

	public function onGetStatus($phone_number, $from, $requested, $id, $time, $data)
	{
	}

	public function onGetSyncResult($result)
	{
	}

	public function onGetVideo($phone_number, $from, $id, $type, $time, $name, $url, $file, $size, $mimeType, $fileHash, $duration, $vcodec, $acodec, $preview, $caption)
	{
	}

	public function onGetvCard($phone_number, $from, $id, $type, $time, $name, $vcardname, $vcard)
	{
	}

	public function onGroupCreate($phone_number, $groupId)
	{
	}

	public function onGroupisCreated($phone_number, $creator, $gid, $subject, $admin, $creation, $members = [])
	{
	}

	public function onGroupsChatCreate($phone_number, $gid)
	{
	}

	public function onGroupsChatEnd($phone_number, $gid)
	{
	}

	public function onGroupsParticipantsAdd($phone_number, $groupId, $jid)
	{
	}

	public function onGroupsParticipantChangedNumber($phone_number, $groupId, $time, $oldNumber, $notify, $newNumber)
	{
	}

	public function onGroupsParticipantsPromote($myNumber, $groupJID, $time, $issuerJID, $issuerName, $promotedJIDs = [])
	{
	}

	public function onGroupsParticipantsRemove($phone_number, $groupId, $jid)
	{
	}

	public function onLoginFailed($phone_number, $data)
	{
	}

	public function onLoginSuccess($phone_number, $kind, $status, $creation, $expiration)
	{
	}

	public function onAccountExpired($phone_number, $kind, $status, $creation, $expiration)
	{
	}

	public function onMediaMessageSent($phone_number, $to, $id, $filetype, $url, $filename, $filesize, $filehash, $caption, $icon)
	{
	}

	public function onMediaUploadFailed($phone_number, $id, $node, $messageNode, $statusMessage)
	{
	}

	public function onMessageComposing($phone_number, $from, $id, $type, $time)
	{
	}

	public function onMessagePaused($phone_number, $from, $id, $type, $time)
	{
	}

	public function onGroupMessageComposing($phone_number, $from_group_jid, $from_user_jid, $id, $type, $time)
	{
	}

	public function onGroupMessagePaused($phone_number, $from_group_jid, $from_user_jid, $id, $type, $time)
	{
	}

	public function onMessageReceivedClient($phone_number, $from, $id, $type, $time, $participant)
	{
	}

	public function onMessageReceivedServer($phone_number, $from, $id, $type, $time)
	{
	}

	public function onNumberWasAdded($phone_number, $jid)
	{
	}

	public function onNumberWasRemoved($phone_number, $jid)
	{
	}

	public function onNumberWasUpdated($phone_number, $jid)
	{
	}

	public function onPaidAccount($phone_number, $author, $kind, $status, $creation, $expiration)
	{
	}

	public function onPaymentRecieved($phone_number, $kind, $status, $creation, $expiration)
	{
	}

	public function onPing($phone_number, $id)
	{
	}

	public function onPresenceAvailable($phone_number, $from)
	{
	}

	public function onPresenceUnavailable($phone_number, $from, $last)
	{
	}

	public function onProfilePictureChanged($phone_number, $from, $id, $time)
	{
	}

	public function onProfilePictureDeleted($phone_number, $from, $id, $time)
	{
	}

	public function onSendMessage($phone_number, $target, $messageId, $node)
	{
	}

	public function onSendMessageReceived($phone_number, $id, $from, $type)
	{
	}

	public function onSendPong($phone_number, $msgid)
	{
	}

	public function onSendPresence($phone_number, $type, $name)
	{
	}

	public function onSendStatusUpdate($phone_number, $txt)
	{
	}

	public function onStreamError($data)
	{
	}

	public function onWebSync($phone_number, $from, $id, $syncData, $code, $name)
	{
	}
}

