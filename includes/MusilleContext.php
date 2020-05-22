<?php

declare(strict_types=1);

namespace LJO\Musille;

use Timber\Menu;

class MusilleContext {

    private Menu $mainMenu;
    private Menu $footerMenu;

    public function __construct() {
        $this->mainMenu   = new Menu('main-menu');
        $this->footerMenu = new Menu('footer-menu');
    }

    public function logo(): string {
        return get_custom_logo();
    }

    public function mainMenu() {
        return $this->mainMenu;
    }

    public function leftMainMenu(): array {
        $items = [];
        foreach ($this->mainMenu->items as $item) {
            if ($item->name == '<logo />') {
                return $items;
            }
            $items[] = $item;
        }
        return array_slice($items, 0, intdiv(count($items) + 1, 2));
    }

    public function rightMainMenu(): array {
        $items = [];
        foreach ($this->mainMenu->items as $item) {
            if ($item->name == '<logo />') {
                $items = [];
            } else {
                $items[] = $item;
            }
        }
        if (count($items) != count($this->mainMenu->items)) {
            return $items;
        } else {
            return array_slice(
                $items,
                intdiv(count($items) + 1, 2),
                intdiv(count($items), 2)
            );
        }
    }
}
