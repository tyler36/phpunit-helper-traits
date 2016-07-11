``# PHPUnit Traits

## Installation
1.Install package through composer.

```
   composer require tyler36/phpunit-helper-traits
```


 ---
## Intro
These traits were designed and tested with Laravel 5.2, with Laravel-elixir 5.
Using laravel-elixir's 'visit' command will test a page is available and generate a crawler object used for some of the tests.
Check the tests directory for further examples and uses.

### CheckAssetExistsTrait
Check if item/s are available, and also appears on the page.
If the string starts with 'http', this trait will make a HTTP request to the web and check if the asset is available.
Usefully for checking CDNs.
Other paths will begin looking in the projects 'public' directory ("app()->publicPath()").
If the tests has a _crawler_ object, this trait will also check if the string is displayed on the page.

*Returns TEST case to allow chaining.

USE:
Include trait within class -  ```use tyler36\phpunitTraits\CheckAssetExistsTrait;```

Call trait with filename or array - ```$this->checkAssetExists($filename);```


EG.

```$this->checkAssetExists("https://code.jquery.com/jquery-3.1.0.min.js");```

```$this->checkAssetExists("/robots.txt");```

```$this->checkAssetExists(["js/jquery.js", "css/main.css"]);```

```$this->visit('/home')->checkAssetExists("/images/logo.jpg")```


### CountElementsTrait
Check page and counts occurrence of specified CSS selector.

USE:
Include trait within class -  ```use tyler36\phpunitTraits\CountElementsTrait;```

Call trait with CSS selector and expected count - ```$this->countElements($selector, $count);```

EG.
```$this->countElements('.card', 3);```


### DisableExceptionHandlerTrait
This trait overwrites the default exception handler, allowing you to check error messages with assertions.

USE:
Include trait within class -  ```use tyler36\phpunitTraits\DisableExceptionHandlerTrait;```

Call trait with CSS selector to disable exception handling - ```$this->disableExceptionHandling()```

Use TRY / CATCH in test.


### ImpersonateTrait
Helper for setting authenticated state.

#### asGuest
Ensure current status is guest (logged out).

USE:
Include trait within class -  ```use tyler36\phpunitTraits\CountElementsTrait;```

EG.
```
$this->asGuest();
```

#### asMember
Ensure current status is member (logged out).
If a user object is passed, this trait will login as that user.
If no user object is passed, this trait will use a 'App\User' factory to create a random User object and log in.

USE:
Include trait within class -  ```use tyler36\phpunitTraits\CountElementsTrait;```

EG.
```
$this->asMember();
```


### MailTrackingTrait
Inspired by [phpunit-testing-in-laravel](https://laracasts.com/series/phpunit-testing-in-laravel/episodes/12)
Check mail options by intercepting sent mails.
You may want to prevent laravel from sending mail by using the log driver; in a test or setUp() function
```
config()->set('mail.driver', 'log');
```

USE:
Include trait within class -  ```use tyler36\phpunitTraits\MailTrackerTrait;```

#### seeEmailWasNotSent
ASSERT:      Mail was NOT sent
```
$this->seeEmailWasNotSent();
```
#### seeEmailWasSent
ASSERT:      Mail was sent
```
$this->seeEmailWasSent();
```

#### seeEmailsSent($count)
ASSERT:     $count number of emails were sent
```
$this->seeEmailsSent(3)
```

#### seeEmailTo($recipient)
ASSERT:      Recipient
```
$this->seeEmailTo($recipient);
```

#### seeEmailNotTo($recipient)
ASSERT:      NOT Recipient
```
$this->seeEmailNotTo($recipient);
```

#### seeEmailFrom($sender)
ASSERT:      Sender
```
$this->seeEmailFrom($sender);
```

#### seeEmailNotFrom($sender)
ASSERT:      NOT Sender
```
$this->seeEmailNotFrom($sender);
```

#### seeEmailEquals($body)
ASSERT:      Body Matches
```
$this->seeEmailEquals($body);
```

#### seeEmailNotEquals($body)
ASSERT:      Body NOT Matches
```
$this->seeEmailNotEquals($body);
```

#### seeEmailContains($excerpt)
ASSERT:      Body contains fragment
```
$this->seeEmailContains($excerpt);
```

#### seeEmailNotContains($excerpt)
ASSERT:      Body NOT contains fragment
```
$this->seeEmailNotContains($excerpt);
```

#### seeEmailSubjectEquals($subject)
ASSERT:      Subject Matches
```
$this->seeEmailSubjectEquals($subject);
```

#### seeEmailSubjectNotEquals($subject)
ASSERT:      Subject NOT Matches
```
$this->seeEmailSubjectNotEquals($subject);
```

#### seeEmailSubjectContains($excerpt)
ASSERT:      Subject contains
```
$this->seeEmailSubjectContains($fragment);
```


#### seeEmailSubjectNotContains($excerpt)
ASSERT:      Subject NOT contains
```
$this->seeEmailSubjectNotContains($fragment);
```


### PrepareFileUploadTrait
Simulate a file upload

Include trait within class -  ```use tyler36\phpunitTraits\PrepareFileUploadTrait;```

Call trait with filename or array - ```$this->prepareUpload($file)```

EG.
```$this->prepareUpload('./avatar.jpg');```
