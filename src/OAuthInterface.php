<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use WebChemistry\OAuthSocial\Exception\OAuthSocialException;
use WebChemistry\OAuthSocial\Identity\OAuthIdentity;

interface OAuthInterface
{

	/**
	 * @throws OAuthSocialException
	 */
	public function getIdentityAndVerify(): OAuthIdentity;

}
