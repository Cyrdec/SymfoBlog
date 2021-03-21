<?php

namespace App\Controller;

/**
 *
 * @author cedric
 */
interface WidgetInterface {
    
    public function getName(): string;
    public function getMethod(): string;
    public function attributes(): array;
}
