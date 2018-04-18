# Twig Bundle

A colection of *useful* Twig filters and functions.


## Installation
You can install this bundle via composer. You will need to manually add the repository by placing this in your projects composer.json file:
```json
{

"repositories": {
    "bundle-TwigBundle": {
        "type": "vcs",
        "url": "https://git.xigen.co.uk/Symfony-Bundles/TwigBundle.git"
    }
}

}
```

and then require the bundle as normal.

```bash
composer require xigen/twig
```

Finally register the bundle in `app/AppKernel.php`:
```php
$bundles = [
    [...]
    new Xigen\Bundle\TwigBundle\TwigBundle(),
];
```
