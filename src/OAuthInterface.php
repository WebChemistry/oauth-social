<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use WebChemistry\OAuthSocial\Exception\OAuthSocialException;
use WebChemistry\OAuthSocial\Identity\OAuthIdentity;

interface OAuthInterface
{

	/**
	 * @param mixed[] $options
	 */
	public function getAuthorizationUrl(array $options = []): string;

	/**
	 * @throws OAuthSocialException
	 */
	public function getIdentityAndVerify(): OAuthIdentity;

}
