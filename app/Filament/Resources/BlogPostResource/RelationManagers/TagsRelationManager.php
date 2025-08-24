<?php

namespace App\Filament\Resources\BlogPostResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Forms\Components\TextInput;
use Filament\Resources\Tables\Columns\TextColumn;
use Filament\Resources\Tables\Actions\DetachAction;
use Filament\Resources\Tables\Actions\AttachAction;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(\Filament\Resources\Form $form): \Filament\Resources\Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('slug')->required()->maxLength(255),
        ]);
    }

    public static function table(\Filament\Resources\Table $table): \Filament\Resources\Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('slug')->label('Slug'),
        ])->headerActions([
            AttachAction::make(),
        ])->actions([
            DetachAction::make(),
        ]);
    }
}
