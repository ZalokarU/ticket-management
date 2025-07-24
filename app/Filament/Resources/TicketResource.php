<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use App\Models\TicketTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Ticket Management';

    protected static ?int $navigationSort = 2;

    // FORM
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Template Selection')
                    ->schema([
                        Forms\Components\Select::make('ticket_template_id')
                            ->label('Ticket Template')
                            ->relationship('ticketTemplate', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $template = TicketTemplate::find($state);
                                    if ($template) {
                                        $set('category_info', ucfirst($template->category));
                                    }
                                }
                            }),

                        Forms\Components\Placeholder::make('category_info')
                            ->label('Template Category')
                            ->content(fn($get) => $get('category_info') ?? 'Select a template first'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Event Information')
                    ->schema([
                        Forms\Components\TextInput::make('event_title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Lakers vs Warriors'),

                        Forms\Components\TextInput::make('venue')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Staples Center'),

                        Forms\Components\DateTimePicker::make('event_date')
                            ->required()
                            ->minDate(now()),

                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->maxValue(9999.99),

                        Forms\Components\TextInput::make('artist_performer')
                            ->maxLength(255)
                            ->placeholder('Main artist/performer'),

                        Forms\Components\TextInput::make('genre')
                            ->maxLength(255)
                            ->placeholder('e.g., Rock, Basketball, Drama'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Seating Information')
                    ->schema([
                        Forms\Components\TextInput::make('section')
                            ->maxLength(50)
                            ->placeholder('e.g., Section A'),

                        Forms\Components\TextInput::make('row')
                            ->maxLength(10)
                            ->placeholder('e.g., Row 5'),

                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'used' => 'Used',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('active')
                            ->required(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Personalization Fields')
                    ->schema([
                        Forms\Components\TextInput::make('var_1')
                            ->label('Variable 1 (e.g., Attendee Name)')
                            ->maxLength(255)
                            ->placeholder('Custom field 1'),

                        Forms\Components\TextInput::make('var_2')
                            ->label('Variable 2 (e.g., Seat Number)')
                            ->maxLength(255)
                            ->placeholder('Custom field 2'),

                        Forms\Components\TextInput::make('var_3')
                            ->label('Variable 3 (e.g., Special Notes)')
                            ->maxLength(255)
                            ->placeholder('Custom field 3'),
                    ])
                    ->columns(3)
                    ->visible(function ($get) {
                        $templateId = $get('ticket_template_id');
                        if ($templateId) {
                            $template = TicketTemplate::find($templateId);
                            return $template?->personalization ?? false;
                        }
                        return false;
                    }),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('additional_info')
                            ->label('Additional Information')
                            ->maxLength(1000)
                            ->rows(3)
                            ->placeholder('Any additional details about this ticket'),

                        Forms\Components\TextInput::make('ticket_number')
                            ->label('Ticket Number')
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Auto-generated'),
                    ])
                    ->columns(1),
            ]);
    }

    // TABLE
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')
                    ->searchable()
                    ->copyable()
                    ->label('Ticket #'),

                Tables\Columns\TextColumn::make('event_title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('ticketTemplate.name')
                    ->label('Template')
                    ->badge()
                    ->color(fn(Ticket $record) => match ($record->ticketTemplate->category) {
                        'sports' => 'primary',
                        'music' => 'success',
                        'theater' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('venue')
                    ->searchable()
                    ->limit(20)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('event_date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'used',
                        'warning' => 'cancelled',
                    ]),

                Tables\Columns\TextColumn::make('var_1')
                    ->label('Custom 1')
                    ->limit(15)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ticket_template_id')
                    ->relationship('ticketTemplate', 'name')
                    ->label('Template'),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'used' => 'Used',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\Filter::make('upcoming')
                    ->query(fn(Builder $query) => $query->where('event_date', '>', now()))
                    ->label('Upcoming Events'),

                Tables\Filters\Filter::make('category')
                    ->form([
                        Forms\Components\Select::make('category')
                            ->options([
                                'sports' => 'Sports',
                                'music' => 'Music',
                                'theater' => 'Theater',
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['category'],
                            fn(Builder $query, $category): Builder => $query->whereHas(
                                'ticketTemplate',
                                fn(Builder $query) => $query->where('category', $category)
                            ),
                        );
                    }),
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
            ])
            ->defaultSort('event_date', 'desc');
    }

    // PAGES
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
