<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial;

use InvalidArgumentException;
use Nette\Application\LinkGenerator;
use WebChemistry\OAuthSocial\Factory\LinkedInOAuthInternalFactoryInterface;

final class LinkedInOAuthAccessor
{

	private string $id;

	private string $secret;

	/** @var string[] */
	private array $instances;

	/** @var GoogleOAuth[] */
	private array $objects = [];

	private LinkGenerator $linkGenerator;

	private LinkedInOAuthInternalFactoryInterface $linkedInOAuthFactory;

	public function __construct(
		string $id,
		string $secret,
		array $instances,
		LinkGenerator $linkGenerator,
		LinkedInOAuthInternalFactoryInterface $linkedInOAuthFactory
	)
	{
		$this->id = $id;
		$this->secret = $secret;
		$this->instances = $instances;
		$this->linkGenerator = $linkGenerator;
		$this->linkedInOAuthFactory = $linkedInOAuthFactory;
	}

	public function get(string $instance): LinkedInOAuth
	{
		if (!isset($this->objects[$instance])) {
			if (!isset($this->instances[$instance])) {
				throw new InvalidArgumentException(sprintf('Instance %s not exists for google auth', $instance));
			}

			$this->objects[$instance] = $this->linkedInOAuthFactory->create(
				$this->id,
				$this->secret,
				$this->linkGenerator->link($this->instances[$instance])
			);
		}

		return $this->objects[$instance];
	}

}
