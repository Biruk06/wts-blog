<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use App\Models\Post;

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
            TD::make('id', 'ID')
                ->width('100px'),

            TD::make('title', 'Заголовок')
                ->render(fn (Post $post) => Link::make($post->title)
                    ->route('platform.posts.edit', $post)),

            TD::make('user.name', 'Автор'),

            TD::make('created_at', 'Создано')
                ->render(fn (Post $post) => $post->created_at->format('d.m.Y H:i')),
        ];
    }
}