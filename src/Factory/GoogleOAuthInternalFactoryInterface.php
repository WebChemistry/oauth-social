<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial\Factory;

use WebChemistry\OAuthSocial\GoogleOAuth;

/**
 * @internal
 */
interface GoogleOAuthInternalFactoryInterface
{

	public function create(string $id, string $secret, string $redirectUrl): GoogleOAuth;

}
