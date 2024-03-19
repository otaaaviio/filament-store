<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Produto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->unique(
                        ignoreRecord: true,
                        modifyRuleUsing: function (Unique $rule) {
                            return $rule->whereNotNull('deleted_at');
                        }
                    )
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->label('Preço')
                    ->required()
                    ->numeric()
                    ->prefix('R$'),
                Forms\Components\TextInput::make('quantity_stock')
                    ->label('Quantidade em Estoque')
                    ->rule('integer')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('product_category_id')
                    ->relationship('category', 'name')
                    ->label('Categoria')
                    ->preload()
                    ->searchable()
                    ->createOptionForm(function ($form) {
                        return $form
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->required(),
                            ]);
                    })
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->label('Descrição')
                    ->required()
                    ->helperText('Descreva o produto de forma clara e objetiva. Aparecerá na página do produto.')
                    ->columnSpanFull(),
                Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                    ->imageEditor()
                    ->label('Imagens')
                    ->helperText('Selecione as imagens do produto.')
                    ->maxFiles(5)
                    ->responsiveImages()
                    ->multiple()
                    ->reorderable()
                    ->rules(['mimes:jpeg,png', 'max:2048'])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->toggleColumnsTriggerAction(function ($action) {
                return $action->button()->label('Colunas');
            })
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filtro');
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('images')
                    ->label('Imagens')
                    ->allCollections()
                    ->limit(2)
                    ->circular(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_stock')
                    ->label('Quantidade em Estoque')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Preço Un.')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('average_rating')
                    ->limit(1)
                    ->label('Média de Avaliação')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrado em')
                    ->dateTime('d/m/y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_category_id')
                    ->relationship('category', 'name')
                    ->label('Categoria'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informações do Produto')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome')
                            ->color('gray'),
                        TextEntry::make('category.name')
                            ->label('Categoria')
                            ->color('gray'),
                        TextEntry::make('price')
                            ->money('BRL')
                            ->label('Preço Un.')
                            ->color('gray'),
                        TextEntry::make('quantity_stock')
                            ->label('Quantidade em Estoque')
                            ->color('gray'),
                        TextEntry::make('Average Rating', 'average_rating')
                            ->label('Média de Avaliação')
                            ->getStateUsing(function ($record) {
                                return $record->average_rating ?? 'Sem avaliações';
                            })
                            ->color('gray'),
                        TextEntry::make('created_at')
                            ->dateTime('d/m/y')
                            ->label('Data de registro'),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->html()
                            ->columnSpanFull()
                            ->color('gray'),
                        SpatieMediaLibraryImageEntry::make('images')
                            ->label('Imagens')
                            ->allCollections()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
        ];
    }
}
