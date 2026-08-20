<?php

namespace App;

// Registered with routes in index.php, dispatched via direct().
class Router
{
    protected array $routes = [];

    public function get(string $uri, $action): static
    {
        return $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, $action): static
    {
        return $this->addRoute('POST', $uri, $action);
    }

    // Registers the same action for GET and POST.
    public function any(string $uri, $action): static
    {
        $this->addRoute('GET', $uri, $action);
        $this->addRoute('POST', $uri, $action);

        return $this;
    }

    protected function addRoute(string $method, string $uri, $action): static
    {
        $this->routes[$method][$this->normalize($uri)] = $action;

        return $this;
    }

    protected function normalize(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        $path = rtrim($path, '/');

        return $path === '' ? '/' : $path;
    }

    // Called once from index.php with the real request; abort(404) if nothing matches.
    public function direct(string $uri, string $method): void
    {
        $uri = $this->normalize($uri);
        $method = strtoupper($method);

        foreach ($this->routes[$method] ?? [] as $route => $action) {
            $pattern = $this->toRegex($route);

            if (preg_match($pattern, $uri, $matches)) {
                $this->call($action, array_slice($matches, 1));
                return;
            }
        }

        abort(404);
    }

    // Turns "/notes/{id}" into "#^/notes/([^/]+)$#".
    protected function toRegex(string $route): string
    {
        $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $route);

        return '#^' . $pattern . '$#';
    }

    // $action is [Controller::class, 'method']; instantiates and calls it with captured params.
    protected function call($action, array $params): void
    {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
            return;
        }

        [$class, $method] = $action;

        call_user_func_array([new $class(), $method], $params);
    }
}
