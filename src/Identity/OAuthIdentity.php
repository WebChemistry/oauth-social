<?php declare(strict_types = 1);

namespace WebChemistry\OAuthSocial\Identity;

final class OAuthIdentity
{

	private string $email;

	private string $name;

	/** @var mixed[] */
	private array $options;

	public function __construct(string $email, string $name, array $options)
	{
		$this->email = $email;
		$this->name = $name;
		$this->options = $options;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return mixed[]
	 */
	public function getOptions(): array
	{
		return $this->options;
	}

}
