<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Enums\OrderStatusEnum;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $title = 'Pedidos';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Código do Pedido'),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->label('Cliente'),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable()
                    ->label('Quantidade do Produto'),
                Tables\Columns\TextColumn::make('status.name')
                    ->color(fn ($record) => OrderStatusEnum::getColor($record->status->order_status_id))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('')
                    ->url(fn ($record) => '/admin/orders/'.$record->order_id),
            ]);
    }
}
