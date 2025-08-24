<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Resources\Resource;
use Filament\Resources\Forms\Components\TextInput;
use Filament\Resources\Forms\Components\RichEditor;
use Filament\Resources\Forms\Components\Toggle;
use Filament\Resources\Forms\Components\DateTimePicker;
use Filament\Resources\Forms\Components\FileUpload;
use Filament\Resources\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Blog';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, $set) {
                    if ($state) {
                        $set('slug', \Str::slug($state));
                    }
                }),

            TextInput::make('slug')
                ->required()
                ->unique(ignorable: fn($record) => $record),

            TextInput::make('excerpt')
                ->label('Krótki opis')
                ->maxLength(500),

            RichEditor::make('content')
                ->label('Treść')
                ->required(),

            FileUpload::make('featured_image')
                ->image()
                ->label('Obraz wyróżniający')
                ->disk('public'),

            FileUpload::make('gallery')
                ->label('Galeria')
                ->image()
                ->multiple()
                ->disk('public')
                ->directory('blog/gallery')
                ->preserveFilenames(),

            Select::make('tags')
                ->label('Tagi')
                ->relationship('tags', 'name')
                ->multiple(),

            Toggle::make('is_featured')->label('Polecany'),
            Toggle::make('is_published')->label('Opublikowany'),
            DateTimePicker::make('published_at')->label('Data publikacji'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->limit(50),
                TextColumn::make('published_at')->date()->sortable(),
                IconColumn::make('is_published')->boolean()->label('Opublikowany'),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
