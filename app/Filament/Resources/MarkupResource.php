<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarkupResource\Pages;
use App\Models\Markup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class MarkupResource extends Resource
{    protected static ?string $model = Markup::class;
    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationLabel = 'Narzuty';
    protected static ?string $navigationGroup = 'Ustawienia kalkulacji';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nazwa')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Opis')
                    ->rows(2),
                Forms\Components\TextInput::make('percent')
                    ->label('Procent narzutu')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('discount_percent')
                    ->label('Upust (%)')
                    ->numeric()
                    ->default(0),
                Forms\Components\DatePicker::make('discount_start')
                    ->label('Upust od'),
                Forms\Components\DatePicker::make('discount_end')
                    ->label('Upust do'),
                Forms\Components\TextInput::make('min_daily_amount_pln')
                    ->label('Minimalna kwota na dzień (PLN)')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_default')
                    ->label('Domyślny narzut')
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nazwa')->searchable(),
                Tables\Columns\TextColumn::make('percent')->label('Procent narzutu')->sortable(),
                Tables\Columns\TextColumn::make('discount_percent')->label('Upust (%)')->sortable(),
                Tables\Columns\TextColumn::make('discount_start')->label('Upust od')->date(),
                Tables\Columns\TextColumn::make('discount_end')->label('Upust do')->date(),
                Tables\Columns\TextColumn::make('min_daily_amount_pln')->label('Min. kwota na dzień (PLN)'),
                Tables\Columns\IconColumn::make('is_default')->label('Domyślny')->boolean(),
            ])
            ->filters([
                // Możesz dodać filtry jeśli potrzebujesz
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarkups::route('/'),
            'create' => Pages\CreateMarkup::route('/create'),
            'edit' => Pages\EditMarkup::route('/{record}/edit'),
        ];
    }
}
