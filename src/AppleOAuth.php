<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use League\OAuth2\Client\Provider\Apple;
use League\OAuth2\Client\Provider\AppleResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Nette\Http\Request;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use WebChemistry\OAuthSocial\Identity\OAuthIdentity;

final class AppleOAuth extends BaseOAuth
{

	private const SESSION_NAMESPACE = 'AppleOAuth';

	private Session $session;

	public function __construct(
		string $clientId,
		string $teamId,
		string $keyId,
		string $keyPath,
		string $redirectUrl,
		Session $session,
		Request $request
	)
	{
		parent::__construct(new Apple([
			'clientId' => $clientId,
			'teamId' => $teamId,
			'keyFileId' => $keyId,
			'keyFilePath' => $keyPath,
			'redirectUri' => $redirectUrl
		]), $request);

		$this->session = $session;
		$this->isPost = true;
	}

	protected function getSession(): SessionSection
	{
		return $this->session->getSection(self::SESSION_NAMESPACE);
	}

	protected function createIdentity(ResourceOwnerInterface $resource, array $options): OAuthIdentity
	{
		assert($resource instanceof AppleResourceOwner);

		$name = implode(' ', array_filter([$resource->getFirstName(), $resource->getLastName()]));

		if (!$name) {
			$name = null;
		}

		return new OAuthIdentity($resource->getEmail(), $name, $options);
	}

}
