<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial\Factory;

use WebChemistry\OAuthSocial\AppleOAuth;

/**
 * @internal
 */
interface AppleOAuthInternalFactoryInterface
{

	public function create(
		string $clientId,
		string $teamId,
		string $keyId,
		string $keyPath,
		string $redirectUrl,
	): AppleOAuth;

}
