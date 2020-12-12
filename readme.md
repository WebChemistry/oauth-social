## Usage

Nette extension:
```neon
extensions:
	oAuthSocial: WebChemistry\OAuthSocial\DI\OAuthSocialExtension

oAuthSocial:
	google:
		id: 'clientId'
		secret: 'clientSecret'
		instances:
			login: 'Module:Presenter:redirection'
	linkedIn:
		id: 'clientId'
		secret: 'clientSecret'
		instances:
			login: 'Module:Presenter:redirection'
```

Presenter
```php
class Presenter
{

	/** @var GoogleOAuthAccessor @inject */
	public GoogleOAuthAccessor $googleOAuthAccessor;

	public function actionLogin(?string $backlink): void
	{
		$this->redirectUrl($this->googleOAuthAccessor->get('login')->getAuthorizationUrl([
			'backlink' => $backlink,
		]));
	}

	public function actionRedirection(): void
	{
		try {
			$identity = $this->googleOAuthAccessor->get('login')->getIdentityAndVerify();

		} catch (OAuthSocialException $exception) {
			$this->flashMessage($exception->getMessage(), 'error');

			$this->redirect('Homepage:');
		} catch (Throwable $exception) {
			$this->flashMessage('Something gone wrong.', 'error');

			$this->redirect('Homepage:');
		}

	}

}
```
