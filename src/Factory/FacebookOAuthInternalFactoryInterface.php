<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial\Factory;

use WebChemistry\OAuthSocial\FacebookOAuth;

interface FacebookOAuthInternalFactoryInterface
{

	public function create(string $id, string $secret, string $redirectUrl): FacebookOAuth;

}
