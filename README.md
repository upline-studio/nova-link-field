# Nova Link Field

```shell
composer require upline/nova-link-field
```
* Link is displayed as a resource link in the index and detail views.
* In forms, the link is shown as a text input.

## Usage

```php
use Upline\NovaLinkField\Link;


class User extends Resource
{
   // ...
   public function fields(NovaRequest $request) 
   {
        return [
            // ...
            Link::make('Instagram')                 // Get link from instagram model field
                ->text(fn() => 'Instagram link')    // Set static anchor 
                ->target('_blank')                  // Set target attribute
        ];   
   }
}
```

```shell
use Upline\NovaLinkField\Link;


class User extends Resource
{
   // ...
   public function fields(NovaRequest $request) 
   {
        return [
            // ...
            Link::make('Instagram', fn($resource) => 'https://instagram.com/' . $resource->instagramId) // Compute link
                ->text('instagram_username')    // Use instagram_username field as anchor text 
                ->target('_blank')
        ];   
   }
}
```

## Why it is better than [formatting text as link](https://nova.laravel.com/docs/4.0/resources/fields.html#formatting-text-as-links)

In this example we don't escape `$username`, so we can get some security troubles. 
```php
Text::make('Twitter Profile', function () {
    $username = $this->twitterUsername;

    return "<a href='https://twitter.com/{$username}'>@{$username}</a>";
})->asHtml(),  
```

Same, using this package:
```php
Link::make('Twitter Profile', function () {
    $username = $this->twitterUsername;
    return "https://twitter.com/{$username}";
})->text('username'),  
```

However, in this case link and username will be escaped. If you need to use html in anchor text, you still can use `asHtml()` method.





