<?php
declare(strict_types=1);

namespace Xigen\Bundle\TwigExtrasBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;

class XigenExtension extends AbstractExtension
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * Full path to public directory
     * @var string
     */
    protected $publicPath;

    /**
     * {@inheritdoc}
     */
    public function __construct(RequestStack $requestStack, KernelInterface $kernel)
    {
        $this->requestStack = $requestStack;
        $this->publicPath = $kernel->getProjectDir() . '/public/';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return[
            new TwigFunction('isCurrentRoute', [$this, 'isCurrentRoute']),
            new TwigFunction('bytesToHumanReadable', [$this, 'bytesToHumanReadable']),
            new TwigFunction('base64Image', [$this, 'base64Image']),
        ];
    }

    /**
     * Check if the current request matches a defined route. Useful for adding the 'active' class to links
     * @param  string|array $route Route to match. Can be a prefix (eg: users_)
     * @param  string $class The string to return if the route matches
     * @return string Return the given class name if the route matches
     */
    public function isCurrentRoute($route, $class = 'active')
    {
        // Get the current request
        $request = $this->requestStack->getCurrentRequest();
        $currentRoute = $request->get('_route');

        // If there is only one route passed as a string, convert it to an array
        if (!is_array($route)) {
            $route = [$route];
        }

        foreach ($route as $test) {
            // Use strpos so that you can also use a route prefix
            if (false !== strpos($currentRoute, $test)) {
                return $class;
            }
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

    public function base64Image($asset)
    {
        $asset = $this->publicPath . $asset;
        $type = pathinfo($asset, PATHINFO_EXTENSION);
        $data = file_get_contents($asset);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
