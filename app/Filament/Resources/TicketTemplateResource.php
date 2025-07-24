<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketTemplateResource\Pages;
use App\Filament\Resources\TicketTemplateResource\RelationManagers;
use App\Models\TicketTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketTemplateResource extends Resource
{
    protected static ?string $model = TicketTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Template Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Sports Event Template'),

                        Forms\Components\Select::make('view')
                            ->required()
                            ->options([
                                'sports' => 'Sports Event',
                                'music' => 'Music Concert',
                                'theater' => 'Theater Show',
                            ])
                            ->placeholder('Select template type'),

                        Forms\Components\Select::make('category')
                            ->required()
                            ->options([
                                'sports' => 'Sports',
                                'music' => 'Music',
                                'theater' => 'Theater',
                            ])
                            ->placeholder('Select category'),

                        Forms\Components\Textarea::make('description')
                            ->maxLength(500)
                            ->rows(3)
                            ->placeholder('Brief description of this template'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Personalization Settings')
                    ->schema([
                        Forms\Components\Toggle::make('personalization')
                            ->label('Enable Personalization')
                            ->helperText('Allow custom fields (var_1, var_2, var_3) to be displayed on tickets')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Template')
                            ->helperText('Only active templates can be used for creating new tickets')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Design Settings')
                    ->schema([
                        Forms\Components\ColorPicker::make('background_color')
                            ->label('Background Color')
                            ->default('#ffffff'),

                        Forms\Components\ColorPicker::make('text_color')
                            ->label('Text Color')
                            ->default('#000000'),

                        Forms\Components\KeyValue::make('design_settings')
                            ->label('Additional Design Settings')
                            ->helperText('Add custom design properties as key-value pairs')
                            ->keyLabel('Property')
                            ->valueLabel('Value'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('view')
                    ->colors([
                        'primary' => 'sports',
                        'success' => 'music',
                        'warning' => 'theater',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\BadgeColumn::make('category')
                    ->colors([
                        'primary' => 'sports',
                        'success' => 'music',
                        'warning' => 'theater',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\IconColumn::make('personalization')
                    ->boolean()
                    ->label('Personalization'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('tickets_count')
                    ->counts('tickets')
                    ->label('Total Tickets'),

                Tables\Columns\ColorColumn::make('background_color')
                    ->label('BG Color'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('view')
                    ->options([
                        'sports' => 'Sports',
                        'music' => 'Music',
                        'theater' => 'Theater',
                    ]),

                Tables\Filters\TernaryFilter::make('personalization')
                    ->label('Personalization Enabled'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Templates'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CustomTicketsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTicketTemplates::route('/'),
            'create' => Pages\CreateTicketTemplate::route('/create'),
            'view' => Pages\ViewTicketTemplate::route('/{record}'),
            'edit' => Pages\EditTicketTemplate::route('/{record}/edit'),
        ];
    }
}
