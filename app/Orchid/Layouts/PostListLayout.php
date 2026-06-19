<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;

class PostListLayout extends Table
{
    /**
     * 
     * @var string
     */
    protected $target = 'posts';

    /**
     *
     * @return array
     */
    protected function columns(): array
    {
        return [
            
        ];
    }
}