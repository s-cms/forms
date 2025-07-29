<?php

namespace SmartCms\Forms\Admin\Resources\ContactForms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use SmartCms\Forms\Enums\ContactFormStatusesEnum;
use SmartCms\Support\Admin\Components\Tables\CreatedAtColumn;
use SmartCms\Support\Admin\Components\Tables\UpdatedAtColumn;

class ContactFormsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prefix'),
                TextColumn::make('status')->label(__('support::admin.status'))->badge(),
                UpdatedAtColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->filters([
                SelectFilter::make('status')->options(ContactFormStatusesEnum::class),
            ])
            ->recordActions([])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
