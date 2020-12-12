<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use WebChemistry\OAuthSocial\Factory\GoogleOAuthInternalFactoryInterface;
use WebChemistry\OAuthSocial\Factory\LinkedInOAuthInternalFactoryInterface;
use WebChemistry\OAuthSocial\GoogleOAuthAccessor;
use WebChemistry\OAuthSocial\LinkedInOAuthAccessor;

class OAuthSocialExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'google' => Expect::structure([
				'id' => Expect::string(),
				'secret' => Expect::string(),
				'instances' => Expect::arrayOf('string'),
			])->assert(
				fn (object $structure) => $structure->id && $structure->secret || (!$structure->id && !$structure->secret),
				'google > id and google > secret must be filled'
			),
			'linkedIn' => Expect::structure([
				'id' => Expect::string(),
				'secret' => Expect::string(),
				'instances' => Expect::arrayOf('string'),
			])->assert(
				fn (object $structure) => $structure->id && $structure->secret || (!$structure->id && !$structure->secret),
				'linkedin > id and linkedin > secret must be filled'
			),
		]);
	}

	public function loadConfiguration(): void
	{
		$config = $this->getConfig();
		$builder = $this->getContainerBuilder();

		if ($config->google->id) {
			$section = $config->google;

			$builder->addFactoryDefinition($this->prefix('googleOAuth'))
				->setImplement(GoogleOAuthInternalFactoryInterface::class);

			$builder->addDefinition($this->prefix('googleOAuthAccessor'))
				->setFactory(GoogleOAuthAccessor::class, [
					$section->id, $section->secret, $section->instances,
				]);
		}

		if ($config->linkedIn->id) {
			$section = $config->linkedIn;

			$builder->addFactoryDefinition($this->prefix('linkedInOAuth'))
				->setImplement(LinkedInOAuthInternalFactoryInterface::class);

			$builder->addDefinition($this->prefix('linkedInOAuthAccessor'))
				->setFactory(LinkedInOAuthAccessor::class, [
					$section->id, $section->secret, $section->instances,
				]);
		}
	}

}
