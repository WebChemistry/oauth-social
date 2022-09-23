<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use WebChemistry\OAuthSocial\AppleOAuthAccessor;
use WebChemistry\OAuthSocial\FacebookOAuthAccessor;
use WebChemistry\OAuthSocial\Factory\AppleOAuthInternalFactoryInterface;
use WebChemistry\OAuthSocial\Factory\FacebookOAuthInternalFactoryInterface;
use WebChemistry\OAuthSocial\Factory\GoogleOAuthInternalFactoryInterface;
use WebChemistry\OAuthSocial\Factory\LinkedInOAuthInternalFactoryInterface;
use WebChemistry\OAuthSocial\Factory\SeznamOAuth2InternalFactoryInterface;
use WebChemistry\OAuthSocial\GoogleOAuthAccessor;
use WebChemistry\OAuthSocial\LinkedInOAuthAccessor;
use WebChemistry\OAuthSocial\SeznamOAuth2Accessor;

class OAuthSocialExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'google' => Expect::structure([
				'id' => Expect::string()->required(),
				'secret' => Expect::string()->required(),
			])->required(false),
			'linkedIn' => Expect::structure([
				'id' => Expect::string()->required(),
				'secret' => Expect::string()->required(),
			])->required(false),
			'facebook' => Expect::structure([
				'id' => Expect::string()->required(),
				'secret' => Expect::string()->required(),
			])->required(false),
			'seznam' => Expect::structure([
				'id' => Expect::string()->required(),
				'secret' => Expect::string()->required(),
			])->required(false),
			'apple' => Expect::structure([
				'clientId' => Expect::string()->required(),
				'teamId' => Expect::string()->required(),
				'keyId' => Expect::string()->required(),
				'keyPath' => Expect::string()->required(),
			])->required(false),
		]);
	}

	public function loadConfiguration(): void
	{
		$config = $this->getConfig();
		$builder = $this->getContainerBuilder();

		if ($config->google) {
			$section = $config->google;

			$builder->addFactoryDefinition($this->prefix('googleOAuth'))
				->setImplement(GoogleOAuthInternalFactoryInterface::class);

			$builder->addDefinition($this->prefix('googleOAuthAccessor'))
				->setFactory(GoogleOAuthAccessor::class, [
					$section->id, $section->secret,
				]);
		}

		if ($config->linkedIn) {
			$section = $config->linkedIn;

			$builder->addFactoryDefinition($this->prefix('linkedInOAuth'))
				->setImplement(LinkedInOAuthInternalFactoryInterface::class);

			$builder->addDefinition($this->prefix('linkedInOAuthAccessor'))
				->setFactory(LinkedInOAuthAccessor::class, [
					$section->id, $section->secret,
				]);
		}

		if ($config->facebook) {
			$section = $config->facebook;

			$builder->addFactoryDefinition($this->prefix('facebookOAuth'))
				->setImplement(FacebookOAuthInternalFactoryInterface::class);

			$builder->addDefinition($this->prefix('facebookOAuthAccessor'))
				->setFactory(FacebookOAuthAccessor::class, [
					$section->id, $section->secret,
				]);
		}

		if ($config->seznam) {
			$section = $config->seznam;

			$builder->addFactoryDefinition($this->prefix('seznamOAuth'))
				->setImplement(SeznamOAuth2InternalFactoryInterface::class);

			$builder->addDefinition($this->prefix('seznamOAuthAccessor'))
				->setFactory(SeznamOAuth2Accessor::class, [
					$section->id, $section->secret,
				]);
		}

		if ($config->apple) {
			$section = $config->apple;

			$builder->addFactoryDefinition($this->prefix('appleOAuth'))
				->setImplement(AppleOAuthInternalFactoryInterface::class);

			$builder->addDefinition($this->prefix('appleOAuthAccessor'))
				->setFactory(AppleOAuthAccessor::class, [
					$section->clientId, $section->teamId, $section->keyId, $section->keyPath,
				]);
		}
	}

}
