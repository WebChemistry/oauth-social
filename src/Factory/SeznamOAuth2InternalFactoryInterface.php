<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial\Factory;

use WebChemistry\OAuthSocial\SeznamOAuth2;

interface SeznamOAuth2InternalFactoryInterface
{

	public function create(string $id, string $secret, string $redirectUrl): SeznamOAuth2;

}
