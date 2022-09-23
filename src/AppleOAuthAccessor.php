<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use WebChemistry\OAuthSocial\Factory\AppleOAuthInternalFactoryInterface;

final class AppleOAuthAccessor implements OAuthAccessorInterface
{

	private string $clientId;

	private string $teamId;

	private string $keyId;

	private string $keyPath;

	private AppleOAuthInternalFactoryInterface $appleOAuthFactory;

	public function __construct(
		string $clientId,
		string $teamId,
		string $keyId,
		string $keyPath,
		AppleOAuthInternalFactoryInterface $appleOAuthFactory
	)
	{
		$this->clientId = $clientId;
		$this->teamId = $teamId;
		$this->keyId = $keyId;
		$this->keyPath = $keyPath;
		$this->appleOAuthFactory = $appleOAuthFactory;
	}

	public function get(string $link): OAuthInterface
	{
		return $this->appleOAuthFactory->create(
			$this->clientId,
			$this->teamId,
			$this->keyId,
			$this->keyPath,
			$link
		);
	}

}
