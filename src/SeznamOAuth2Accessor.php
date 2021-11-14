<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use WebChemistry\OAuthSocial\Factory\SeznamOAuth2InternalFactoryInterface;

final class SeznamOAuth2Accessor implements OAuthAccessorInterface
{

	private string $id;

	private string $secret;

	private SeznamOAuth2InternalFactoryInterface $seznamOAuth2Factory;

	public function __construct(string $id, string $secret, SeznamOAuth2InternalFactoryInterface $seznamOAuth2Factory)
	{
		$this->id = $id;
		$this->secret = $secret;
		$this->seznamOAuth2Factory = $seznamOAuth2Factory;
	}

	public function get(string $link): SeznamOAuth2
	{
		return $this->seznamOAuth2Factory->create(
			$this->id,
			$this->secret,
			$link
		);
	}

}
