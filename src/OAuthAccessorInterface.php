<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

interface OAuthAccessorInterface
{

	public function get(string $link): OAuthInterface;

}
