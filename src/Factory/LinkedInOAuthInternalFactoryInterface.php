<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial\Factory;

use WebChemistry\OAuthSocial\LinkedInOAuth;

/**
 * @internal
 */
interface LinkedInOAuthInternalFactoryInterface
{

	public function create(string $id, string $secret, string $redirectUrl): LinkedInOAuth;

}
