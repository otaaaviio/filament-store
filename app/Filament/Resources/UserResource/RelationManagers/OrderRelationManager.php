<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Enums\OrderStatusEnum;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;

class OrderRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $title = 'Pedidos';

    /**
     * @throws \Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filtros');
            })
            ->toggleColumnsTriggerAction(function ($action) {
                return $action->button()->label('Colunas');
            })
            ->recordTitleAttribute('user_id')
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Código do Pedido')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('products')
                    ->getStateUsing(function ($record) {
                        return $record->products->sum('pivot.quantity');
                    })
                    ->label('N° de Produtos')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Preço Total')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data do Pedido')
                    ->dateTime('d/m/y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status.name')
                    ->color(fn ($record) => OrderStatusEnum::getColor($record->status->order_status_id))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order_status_id')
                    ->relationship('status', 'name')
                    ->label('Status'),
            ])
            ->actions([
                ViewAction::make()
                    ->label('')
                    ->url(fn ($record) => '/admin/orders/'.$record->order_id),
            ]);
    }
}
