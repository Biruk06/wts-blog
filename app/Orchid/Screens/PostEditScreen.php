<?php

namespace App\Orchid\Screens;

use App\Models\Post;
use App\Models\User;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Select;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\facades\alert;

use Illuminate\Http\Request;

class PostEditScreen extends Screen
{

    public ?Post $post = null;

    
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Post $post): array
    {
        $this->post = $post;   

        return [
            'post' => $post
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ($this->post && $this->post->exists) ? 'Редактировать публикацию' : 'Создать публикацию';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('bs.check-circle')
                ->method('createOrUpdate'),
            
            Button::make('Удалить пост')
                ->icon('bs.trash')
                ->confirm('Вы уверены, что хотите удалить эту публикацию?')
                ->method('remove')
                ->canSee($this->post && $this->post->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('post.title')
                    ->title('Заголовок')
                    ->placeholder('Введите заголовок публикации')
                    ->required(),

                TextArea::make('post.text')
                    ->title('Текст публикации')
                    ->placeholder('Введите текст публикации')
                    ->rows(10)
                    ->required(),

                Select::make('post.user_id')
                    ->fromModel(User::class, 'name')
                    ->title('Автор публикации')
                    ->required(),
            ]),
        ];
    }


    public function createOrUpdate(Post $post, Request $request)
    {
        $request->validate([
            'post.title' => 'required|string|min:5|max:255',
            'post.text' => 'required|string|min:10',
            'post.user_id' => 'required|exists:users,id',
        ]);
    
        $post->fill($request->get('post'))->save();

        alert()->info('Публикация успешно сохранена.');

        return redirect()->route('platform.posts');
    }

    public function remove(Post $post)
    {
        $post->delete();

        alert()->warning('Публикация успешно удалена.');

        return redirect()->route('platform.posts');
    }
}