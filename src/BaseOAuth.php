<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use Exception;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Nette\Http\Request;
use Nette\Http\SessionSection;
use WebChemistry\OAuthSocial\Exception\OAuthSocialException;
use WebChemistry\OAuthSocial\Identity\OAuthIdentity;

abstract class BaseOAuth implements OAuthInterface
{

	protected AbstractProvider $provider;

	private Request $request;

	public function __construct(AbstractProvider $provider, Request $request)
	{
		$this->provider = $provider;
		$this->request = $request;
	}

	public function getProvider(): AbstractProvider
	{
		return $this->provider;
	}

	abstract protected function getSession(): SessionSection;

	abstract protected function createIdentity(ResourceOwnerInterface $resource, array $options): OAuthIdentity;

	/**
	 * @param mixed[] $options
	 */
	public function getAuthorizationUrl(array $options = []): string
	{
		$link = $this->provider->getAuthorizationUrl();
		$session = $this->getSession();

		$options['state'] = $this->provider->getState();

		foreach ($options as $key => $value) {
			$session[$key] = $value;
		}

		return $link;
	}

	public function getIdentityAndVerify(): OAuthIdentity
	{
		$code = $this->request->getQuery('code');
		if (!$code) {
			throw new OAuthSocialException('Invalid code given, try it again');
		}

		if ($error = $this->request->getQuery('error')) {
			throw new OAuthSocialException($error);
		}

		$session = iterator_to_array($this->getSession());
		$state = $this->request->getQuery('state');
		if (!$state || !isset($session['state']) || $state !== $session['state']) {
			throw new OAuthSocialException('CSRF detected, try it again');
		}

		unset($session['state']);

		try {
			$token = $this->provider->getAccessToken('authorization_code', [
				'code' => $code,
			]);
		} catch (IdentityProviderException $e) {
			if ($e->getMessage() === 'invalid_grant') {
				throw new OAuthSocialException('Something gone wrong, please try again.', previous: $e);
			}

			throw $e;
		}

		try {
			$resourceOwner = $this->provider->getResourceOwner($token);
		} catch (Exception $e) {
			throw new OAuthSocialException($e->getMessage(), 0, $e);
		}

		return $this->createIdentity($resourceOwner, $session);
	}

}
