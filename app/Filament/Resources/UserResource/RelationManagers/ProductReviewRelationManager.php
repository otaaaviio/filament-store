<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProductReviewRelationManager extends RelationManager
{
    protected static string $relationship = 'productReviews';

    protected static ?string $title = 'Avaliações de Produtos';

    public function table(Table $table): Table
    {
        return $table
            ->toggleColumnsTriggerAction(function ($action) {
                return $action->button()->label('Colunas');
            })
            ->recordTitleAttribute('user_id')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produto')
                    ->url(fn ($record) => '/admin/products/'.$record->product_id)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('review')
                    ->label('Descrição da Avaliação')
                    ->limit(30)
                    ->searchable()
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->getStateUsing(fn ($record) => str_repeat('⭐ ', $record->rating))
                    ->label('Avaliação')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/y')
                    ->label('Data da Avaliação')
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
