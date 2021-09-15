<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use InvalidArgumentException;
use Nette\Application\LinkGenerator;
use WebChemistry\OAuthSocial\Factory\FacebookOAuthInternalFactoryInterface;

final class FacebookOAuthAccessor implements OAuthAccessorInterface
{

	private string $id;

	private string $secret;

	private FacebookOAuthInternalFactoryInterface $facebookOAuthFactory;

	public function __construct(
		string $id,
		string $secret,
		FacebookOAuthInternalFactoryInterface $facebookOAuthFactory
	)
	{
		$this->id = $id;
		$this->secret = $secret;
		$this->facebookOAuthFactory = $facebookOAuthFactory;
	}

	public function get(string $link): FacebookOAuth
	{
		return $this->facebookOAuthFactory->create(
			$this->id,
			$this->secret,
			$link
		);
	}

}
