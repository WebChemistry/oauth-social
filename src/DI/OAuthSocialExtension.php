<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use WebChemistry\OAuthSocial\FacebookOAuthAccessor;
use WebChemistry\OAuthSocial\Factory\FacebookOAuthInternalFactoryInterface;
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
			])->assert(
				fn (object $structure) => $structure->id && $structure->secret || (!$structure->id && !$structure->secret),
				'google > id and google > secret must be filled'
			),
			'linkedIn' => Expect::structure([
				'id' => Expect::string(),
				'secret' => Expect::string(),
			])->assert(
				fn (object $structure) => $structure->id && $structure->secret || (!$structure->id && !$structure->secret),
				'linkedin > id and linkedin > secret must be filled'
			),
			'facebook' => Expect::structure([
				'id' => Expect::string(),
				'secret' => Expect::string(),
			])->assert(
				fn (object $structure) => $structure->id && $structure->secret || (!$structure->id && !$structure->secret),
				'facebook > id and facebook > secret must be filled'
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
					$section->id, $section->secret,
				]);
		}

		if ($config->linkedIn->id) {
			$section = $config->linkedIn;

			$builder->addFactoryDefinition($this->prefix('linkedInOAuth'))
				->setImplement(LinkedInOAuthInternalFactoryInterface::class);

			$builder->addDefinition($this->prefix('linkedInOAuthAccessor'))
				->setFactory(LinkedInOAuthAccessor::class, [
					$section->id, $section->secret,
				]);
		}

		if ($config->facebook->id) {
			$section = $config->facebook;

			$builder->addFactoryDefinition($this->prefix('linkedInOAuth'))
				->setImplement(FacebookOAuthInternalFactoryInterface::class);

			$builder->addDefinition($this->prefix('linkedInOAuthAccessor'))
				->setFactory(FacebookOAuthAccessor::class, [
					$section->id, $section->secret,
				]);
		}
	}

}
