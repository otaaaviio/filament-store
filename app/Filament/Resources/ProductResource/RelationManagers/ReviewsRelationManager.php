<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    protected static ?string $title = 'Avaliações';

    public function table(Table $table): Table
    {
        return $table
            ->toggleColumnsTriggerAction(function ($action) {
                return $action->button()->label('Colunas');
            })
            ->recordTitleAttribute('product_id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->url(fn ($record) => '/admin/users/'.$record->user->user_id)
                    ->searchable()
                    ->sortable()
                    ->label('Cliente'),
                Tables\Columns\TextColumn::make('review')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    })
                    ->sortable()
                    ->label('Descrição'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime('d/m/y')
                    ->label('Data da Avaliação'),
                Tables\Columns\TextColumn::make('star_rating')
                    ->sortable(query: fn (Builder $query, $direction) => $query->orderBy('rating', $direction))
                    ->label('Nota'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ]);
    }
}
