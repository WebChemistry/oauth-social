<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Nette\Http\IRequest;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use WebChemistry\OAuth2\Client\Seznam\Provider\Seznam;
use WebChemistry\OAuth2\Client\Seznam\Provider\SeznamUser;
use WebChemistry\OAuthSocial\Identity\OAuthIdentity;

class SeznamOAuth2 extends BaseOAuth
{

	private const SESSION_NAMESPACE = 'SeznamOAuth2';

	private Session $session;

	public function __construct(string $id, string $secret, string $redirectUrl, Session $session, IRequest $request)
	{
		parent::__construct(new Seznam([
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
		assert($resource instanceof SeznamUser);

		return new OAuthIdentity($resource->getEmail(), $resource->getName(), $options);
	}

}
