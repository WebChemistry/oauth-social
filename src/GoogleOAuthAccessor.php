<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use InvalidArgumentException;
use Nette\Application\LinkGenerator;
use WebChemistry\OAuthSocial\Factory\GoogleOAuthInternalFactoryInterface;
use WebChemistry\OAuthSocial\Factory\LinkedInOAuthInternalFactoryInterface;

final class GoogleOAuthAccessor
{

	private string $id;

	private string $secret;

	/** @var string[] */
	private array $instances;

	/** @var GoogleOAuth[] */
	private array $objects = [];

	private LinkGenerator $linkGenerator;

	private GoogleOAuthInternalFactoryInterface $googleOAuthFactory;

	public function __construct(
		string $id,
		string $secret,
		array $instances,
		LinkGenerator $linkGenerator,
		GoogleOAuthInternalFactoryInterface $googleOAuthFactory
	)
	{
		$this->id = $id;
		$this->secret = $secret;
		$this->instances = $instances;
		$this->linkGenerator = $linkGenerator;
		$this->googleOAuthFactory = $googleOAuthFactory;
	}

	public function get(string $instance): GoogleOAuth
	{
		if (!isset($this->objects[$instance])) {
			if (!isset($this->instances[$instance])) {
				throw new InvalidArgumentException(sprintf('Instance %s not exists for google auth', $instance));
			}

			$this->objects[$instance] = $this->googleOAuthFactory->create(
				$this->id,
				$this->secret,
				$this->linkGenerator->link($this->instances[$instance])
			);
		}

		return $this->objects[$instance];
	}

}
