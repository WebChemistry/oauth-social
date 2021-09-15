<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use InvalidArgumentException;
use Nette\Application\LinkGenerator;
use WebChemistry\OAuthSocial\Factory\LinkedInOAuthInternalFactoryInterface;

final class LinkedInOAuthAccessor implements OAuthAccessorInterface
{

	private string $id;

	private string $secret;

	private LinkedInOAuthInternalFactoryInterface $linkedInOAuthFactory;

	public function __construct(
		string $id,
		string $secret,
		LinkedInOAuthInternalFactoryInterface $linkedInOAuthFactory
	)
	{
		$this->id = $id;
		$this->secret = $secret;
		$this->linkedInOAuthFactory = $linkedInOAuthFactory;
	}

	public function get(string $link): LinkedInOAuth
	{
		return $this->linkedInOAuthFactory->create(
			$this->id,
			$this->secret,
			$link
		);
	}

}
