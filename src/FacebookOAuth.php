<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\FacebookUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Nette\Http\Request;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use WebChemistry\OAuthSocial\Exception\OAuthSocialException;
use WebChemistry\OAuthSocial\Identity\OAuthIdentity;

class FacebookOAuth extends BaseOAuth
{

	private const SESSION_NAMESPACE = 'FacebookOAuth';

	private Session $session;

	public function __construct(string $id, string $secret, string $redirectUrl, Session $session, Request $request)
	{
		parent::__construct(new Facebook([
			'clientId' => $id,
			'clientSecret' => $secret,
			'redirectUri' => $redirectUrl,
			'graphApiVersion' => 'v2.10',
		]), $request);

		$this->session = $session;
	}

	protected function getSession(): SessionSection
	{
		return $this->session->getSection(self::SESSION_NAMESPACE);
	}

	protected function createIdentity(ResourceOwnerInterface $resource, array $options): OAuthIdentity
	{
		assert($resource instanceof FacebookUser);

		if (!$resource->getEmail()) {
			throw new OAuthSocialException('You must grant access to obtain your email.');
		}

		if (!$resource->getName()) {
			throw new OAuthSocialException('You must grant access to obtain your email.');
		}

		return new OAuthIdentity($resource->getEmail(), $resource->getName(), $options);
	}

}
