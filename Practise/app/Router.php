<?php

namespace App;

// A small class-based router — this is what replaced the old flat
// router.php once routes needed dynamic segments like {id} and
// per-verb matching. Register routes with get()/post()/any(), then
// call direct() once with the real request to actually run one.
class Router
{
    protected array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    // Registers the same handler for both GET and POST — used for
    // pages like /notes/create that show a form on GET and save it on POST.
    public function any(string $path, array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
        $this->addRoute('POST', $path, $handler);
    }

    protected function addRoute(string $method, string $path, array $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
        ];
    }

    // Takes the real request (REQUEST_URI + REQUEST_METHOD), finds the
    // first route that matches, and calls its controller action —
    // passing along any {id}-style segments as arguments.
    public function direct(string $uri, string $method): void
    {
        // Strip off any query string (?foo=bar) before matching.
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        // Normalize a trailing slash so "/about/" still matches "/about".
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $params = $this->match($route['path'], $path);

            // Use !== null rather than a truthy check — a matched route
            // with no {id}-style segments legitimately returns an empty
            // array, which is falsy in PHP and would otherwise look like
            // "no match" here.
            if ($params !== null) {
                [$class, $action] = $route['handler'];
                $controller = new $class();
                $controller->$action(...$params);

                return;
            }
        }

        // Nothing matched any registered route — give up with a 404.
        abort(404);
    }

    // Turns a route like "/notes/{id}" into a regex, tries it against
    // the real path, and returns the captured segments (e.g. the id)
    // if it matches — or null if it doesn't.
    protected function match(string $routePath, string $requestPath): ?array
    {
        $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $requestPath, $matches)) {
            return null;
        }

        array_shift($matches); // drop the full-string match, keep only the captured segments

        return $matches; // may legitimately be [] for routes with no {id}-style segments
    }
}
