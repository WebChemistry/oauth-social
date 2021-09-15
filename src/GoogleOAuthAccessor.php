<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use InvalidArgumentException;
use Nette\Application\LinkGenerator;
use WebChemistry\OAuthSocial\Factory\GoogleOAuthInternalFactoryInterface;
use WebChemistry\OAuthSocial\Factory\LinkedInOAuthInternalFactoryInterface;

final class GoogleOAuthAccessor implements OAuthAccessorInterface
{

	private string $id;

	private string $secret;

	private GoogleOAuthInternalFactoryInterface $googleOAuthFactory;

	public function __construct(
		string $id,
		string $secret,
		GoogleOAuthInternalFactoryInterface $googleOAuthFactory
	)
	{
		$this->id = $id;
		$this->secret = $secret;
		$this->googleOAuthFactory = $googleOAuthFactory;
	}

	public function get(string $link): GoogleOAuth
	{
		return $this->googleOAuthFactory->create(
			$this->id,
			$this->secret,
			$link
		);
	}

}
