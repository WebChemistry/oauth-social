<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use Firebase\JWT\JWT;
use League\OAuth2\Client\Provider\LinkedIn;
use League\OAuth2\Client\Provider\LinkedInResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Nette\Http\IRequest;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use WebChemistry\OAuthSocial\Identity\OAuthIdentity;

class LinkedInOAuth extends BaseOAuth
{

	private const SESSION_NAMESPACE = 'LinkedInOAuth';

	private Session $session;

	public function __construct(string $id, string $secret, string $redirectUrl, Session $session, IRequest $request)
	{
		JWT::$leeway = 60;

		parent::__construct(new LinkedIn([
			'clientId' => $id,
			'clientSecret' => $secret,
			'redirectUri' => $redirectUrl,
		]), $request);

		$this->session = $session;
	}

	protected function getSession(): SessionSection
	{
		return $this->session->getSection(self::SESSION_NAMESPACE);
	}

	protected function createIdentity(ResourceOwnerInterface $resource, array $options): OAuthIdentity
	{
		assert($resource instanceof LinkedInResourceOwner);

		$space = $resource->getFirstName() && $resource->getLastName() ? ' ' : '';

		return new OAuthIdentity($resource->getEmail(), $resource->getFirstName() . $space . $resource->getLastName(), $options);
	}

}
