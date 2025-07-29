<?php

namespace SmartCms\Forms\Admin\Resources\Forms\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use SmartCms\Forms\Admin\Resources\Forms\FormResource;
use SmartCms\Forms\Models\Form;

class ListForms extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('_create')->color('primary')->label('Create Form')->schema([
                TextInput::make('name')->required(),
            ])
                ->modalWidth(Width::ExtraLarge)
                ->action(function (array $data) {
                    $form = Form::query()->create($data);

                    return redirect()->to(FormResource::getUrl('edit', ['record' => $form->id]));
                }),
        ];
    }
}
