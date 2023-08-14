<?php

declare(strict_types=1);

namespace app\View;

use app\Exception\ViewNotFoundException;

class View
{
    protected string $view;
    protected array $params = [];
    private string $viewPath;

    public function __construct(string $view, array $params = [])
    {
        $this->view = $view;
        $this->params = $params;
        $this->viewPath = __DIR__ . '/../../views/' . $this->view . '.php';
    }

    protected function includeContent(): string
    {
        $viewPath = $this->viewPath;

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        extract($this->params);
        ob_start();
        include $viewPath;
        $content = ob_get_clean();
        return $content;
    }

    public static function make(string $view, array $params = []): self
    {
        return new static($view, $params);
    }

    public function render(string $layout = 'layout.php'): bool|string
    {
        $layoutPath = __DIR__ . '/../../views/' . $layout;

        if (!file_exists($layoutPath)) {
            throw new ViewNotFoundException();
        }

        $pageContent = $this->includeContent();

        extract($this->params);
        ob_start();
        include $layoutPath;
        $pageView  = ob_get_clean();

        return $pageView;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}



    // protected function includeParams(array $params = []): void
    // {
    //     extract($params);
    //     include $path;
    // }

    // protected function includeView(string $path): string
    // {
    //     ob_start();
    //     $this->includeParams($this->params);
    //     return ob_get_clean();
    // }
