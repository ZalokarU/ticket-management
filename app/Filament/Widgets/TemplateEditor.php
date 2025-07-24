<?php

namespace App\Filament\Widgets;

use App\Models\TicketTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class TemplateEditor extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.template-editor';

    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    public ?array $data = [];

    public ?TicketTemplate $selectedTemplate = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Template Content Editor')
                    ->description('Select a template to edit its content and preview changes')
                    ->schema([
                        Forms\Components\Select::make('template_id')
                            ->label('Select Template')
                            ->options(TicketTemplate::active()->pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state) {
                                if ($state) {
                                    $this->selectedTemplate = TicketTemplate::find($state);
                                    $this->dispatch('template-selected', templateId: $state);
                                } else {
                                    $this->selectedTemplate = null;
                                }
                            }),

                        Forms\Components\Placeholder::make('template_info')
                            ->label('Template Information')
                            ->content(function ($get) {
                                $templateId = $get('template_id');
                                if ($templateId && $this->selectedTemplate) {
                                    return "Category: " . ucfirst($this->selectedTemplate->category) .
                                           " | View: " . ucfirst($this->selectedTemplate->view) .
                                           " | Personalization: " . ($this->selectedTemplate->personalization ? 'Enabled' : 'Disabled');
                                }
                                return 'Select a template to view information';
                            })
                            ->visible(fn ($get) => $get('template_id')),
                    ]),

                Forms\Components\Section::make('Design Customization')
                    ->schema([
                        Forms\Components\ColorPicker::make('background_color')
                            ->label('Background Color')
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get) {
                                $this->updateTemplateDesign($get('template_id'), 'background_color', $state);
                            }),

                        Forms\Components\ColorPicker::make('text_color')
                            ->label('Text Color')
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get) {
                                $this->updateTemplateDesign($get('template_id'), 'text_color', $state);
                            }),

                        Forms\Components\Select::make('font_family')
                            ->label('Font Family')
                            ->options([
                                'Arial, sans-serif' => 'Arial',
                                'Georgia, serif' => 'Georgia',
                                'Times New Roman, serif' => 'Times New Roman',
                                'Courier New, monospace' => 'Courier New',
                                'Helvetica, sans-serif' => 'Helvetica',
                            ])
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get) {
                                $this->updateTemplateDesignSetting($get('template_id'), 'font_family', $state);
                            }),

                        Forms\Components\Select::make('border_style')
                            ->label('Border Style')
                            ->options([
                                'none' => 'None',
                                'solid' => 'Solid',
                                'dashed' => 'Dashed',
                                'dotted' => 'Dotted',
                                'double' => 'Double',
                            ])
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get) {
                                $this->updateTemplateDesignSetting($get('template_id'), 'border_style', $state);
                            }),
                    ])
                    ->columns(2)
                    ->visible(fn ($get) => $get('template_id')),

                Forms\Components\Section::make('Content Settings')
                    ->schema([
                        Forms\Components\Toggle::make('show_qr_code')
                            ->label('Show QR Code')
                            ->default(true)
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get) {
                                $this->updateTemplateDesignSetting($get('template_id'), 'show_qr_code', $state);
                            }),

                        Forms\Components\Toggle::make('show_logo')
                            ->label('Show Logo')
                            ->default(true)
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get) {
                                $this->updateTemplateDesignSetting($get('template_id'), 'show_logo', $state);
                            }),

                        Forms\Components\TextInput::make('header_text')
                            ->label('Header Text')
                            ->placeholder('e.g., ADMIT ONE')
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get) {
                                $this->updateTemplateDesignSetting($get('template_id'), 'header_text', $state);
                            }),

                        Forms\Components\TextInput::make('footer_text')
                            ->label('Footer Text')
                            ->placeholder('e.g., Thank you for attending!')
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get) {
                                $this->updateTemplateDesignSetting($get('template_id'), 'footer_text', $state);
                            }),
                    ])
                    ->columns(2)
                    ->visible(fn ($get) => $get('template_id')),
            ])
            ->statePath('data');
    }

    protected function updateTemplateDesign(int $templateId, string $field, $value): void
    {
        if (!$templateId) return;

        $template = TicketTemplate::find($templateId);
        if ($template) {
            $template->update([$field => $value]);
            $this->selectedTemplate = $template->fresh();

            Notification::make()
                ->title('Template Updated')
                ->body("$field has been updated successfully.")
                ->success()
                ->send();
        }
    }

    protected function updateTemplateDesignSetting(int $templateId, string $setting, $value): void
    {
        if (!$templateId) return;

        $template = TicketTemplate::find($templateId);
        if ($template) {
            $designSettings = $template->design_settings ?? [];
            $designSettings[$setting] = $value;
            $template->update(['design_settings' => $designSettings]);
            $this->selectedTemplate = $template->fresh();

            Notification::make()
                ->title('Design Setting Updated')
                ->body("$setting has been updated successfully.")
                ->success()
                ->send();
        }
    }

    public function resetTemplate(): void
    {
        if ($this->selectedTemplate) {
            $this->selectedTemplate->update([
                'background_color' => '#ffffff',
                'text_color' => '#000000',
                'design_settings' => null,
            ]);

            $this->form->fill();

            Notification::make()
                ->title('Template Reset')
                ->body('Template design has been reset to defaults.')
                ->success()
                ->send();
        }
    }

    public function previewTemplate(): void
    {
        if ($this->selectedTemplate) {
            $this->dispatch('open-preview-modal', templateId: $this->selectedTemplate->id);
        }
    }
}
