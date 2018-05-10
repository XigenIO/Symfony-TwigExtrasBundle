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
            new TwigFunction('bytesToHumanReadable', [$this, 'bytesToHumanReadable']),
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

    /**
     * Format file size to a human readable format
     * @link http://jeffreysambells.com/2012/10/25/human-readable-filesize-php
     * @param  integer $bytes
     * @return string
     */
    public function bytesToHumanReadable($bytes)
    {
        $bytes = (string) $bytes;
        $size = ['B','kB','MB','GB','TB','PB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.2f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}
