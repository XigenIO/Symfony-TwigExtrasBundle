<?php
declare(strict_types=1);

namespace Xigen\Bundle\TwigExtrasBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use Symfony\Component\HttpFoundation\RequestStack;

class XigenExtension extends AbstractExtension
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * {@inheritdoc}
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return[
            new TwigFunction('isCurrentRoute', [$this, 'isCurrentRoute']),
        ];
    }

    /**
     * Check if the current request matches a defined route. Useful for adding the 'active' class to links
     * @param  string $route Route to match. Can be a prefix (eg: users_)
     * @param  string $calss The string to return if the route matches
     * @return string Return the given class name if the route matches
     */
    public function isCurrentRoute($route, $calss = 'active')
    {
        // Get the current request
        $request = $this->requestStack->getCurrentRequest();

        // Use strpos so that you can also use a route prefix
        if (false !== strpos($request->get('_route'), $route)) {
            return $calss;
        }

        return '';
    }
}
