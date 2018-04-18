# Twig Bundle

A colection of *useful* Twig filters and functions.


## Installation
You can install this bundle via composer. You will need to manually add the repository by placing this in your projects composer.json file:
```json
{

"repositories": {
    "bundle-TwigExtrasBundle": {
        "type": "vcs",
        "url": "https://git.xigen.co.uk/Symfony-Bundles/TwigExtrasBundle.git"
    }
}

}
```

and then require the bundle as normal.

```bash
composer require xigen/twig
```

Register the bundle in `app/AppKernel.php`:
(This is done for you automatically in Symfony 4)
```php
$bundles = [
    [...]
    new Xigen\Bundle\TwigExtrasBundle\TwigExtrasBundle(),
];
```

Finaly register the twig extension in `config/packages/twig_extensions.yaml`:
