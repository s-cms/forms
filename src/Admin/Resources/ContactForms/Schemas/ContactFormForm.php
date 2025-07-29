<?php

namespace SmartCms\Forms\Admin\Resources\ContactForms\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use SmartCms\Forms\Enums\ContactFormStatusesEnum;
use SmartCms\Support\Admin\Components\Layout\Aside;
use SmartCms\Support\Admin\Components\Layout\FormGrid;
use SmartCms\Support\Admin\Components\Layout\LeftGrid;
use SmartCms\Support\Admin\Components\Layout\RightGrid;

class ContactFormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FormGrid::make()->schema([
                    LeftGrid::make()->schema([
                        Section::make()->compact()->schema([
                            TextInput::make('prefix')->label(__('support::admin.name'))->disabled(),
                        ]),
                        KeyValue::make('data')->deletable(false)->hiddenLabel()->keyLabel(__('kit::admin.form_data_key'))->valueLabel(__('kit::admin.form_data_value')),
                        Section::make()->compact()->schema([
                            Textarea::make('comment')->label(__('kit::admin.comment'))->maxLength(255)->columnSpanFull(),
                        ]),
                    ]),
                    RightGrid::make()->schema([
                        Aside::make(),
                        Section::make()->compact()->schema([
                            Select::make('status')->options(ContactFormStatusesEnum::class),
                        ]),
                    ]),
                ]),
            ]);
    }
}
