<?php

declare(strict_types=1);

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = VIEW_PATH . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $view) . '.php';

        if (!is_file($viewFile)) {
            throw new RuntimeException('Vue introuvable: ' . $view);
        }

        require VIEW_PATH . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'main.php';
    }

    protected function validateRequired(array $input, array $fields): array
    {
        $errors = [];

        foreach ($fields as $field => $label) {
            if (!isset($input[$field]) || trim((string) $input[$field]) === '') {
                $errors[$field] = $label . ' est obligatoire.';
            }
        }

        return $errors;
    }
}
