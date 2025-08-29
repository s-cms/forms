<?php

namespace SmartCms\Forms\Components;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use SmartCms\Forms\Models\ContactForm;
use SmartCms\Forms\Models\Form;

/**
 * @property Form $model
 * @property array $data
 * @property mixed $form
 */
class FormComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public Form $options;

    public ?array $data = [];

    public function form(Schema $schema): Schema
    {
        $form = [];
        foreach ($this->options->fields as $field) {
            $name = str()->slug($field['label']);
            $formField = match ($field['type']) {
                'select' => Select::make($name)->options($field['options'])->label($field['label']),
                'textarea' => Textarea::make($name)->label($field['label']),
                'checkbox' => Checkbox::make($name)->label($field['label']),
                'radio' => Radio::make($name)->options($field['options'])->label($field['label']),
                default => TextInput::make($name)->label($field['label']),
            };
            $form[] = $formField->required($field['required'] ?? true);
        }

        return $schema->schema($form)->statePath('data');
    }

    public function render(): View
    {
        return view('livewire.demo-form', [
            'form' => $this->form,
        ]);
    }

    public function create()
    {
        $this->form->validate();
        $state = $this->form->getState();
        ContactForm::query()->create([
            'prefix' => $this->options->name,
            'data' => $state,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer_url' => request()->headers->get('referer'),
        ]);
        $this->dispatch('form-submitted');
        $this->form->fill([]);
    }
}
