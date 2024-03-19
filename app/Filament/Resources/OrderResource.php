<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatusEnum;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Exception;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Pedido';

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
                return $action->button()->label('Filtros');
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('products')
                    ->getStateUsing(function ($record) {
                        return $record->products->sum('pivot.quantity');
                    })
                    ->label('N° de Produtos'),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('BRL')
                    ->label('Valor Total'),
                Tables\Columns\TextColumn::make('status.name')
                    ->color(fn ($record) => OrderStatusEnum::getColor($record->status->order_status_id))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data do Pedido')
                    ->dateTime('d/m/y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order_status_id')
                    ->label('Status')
                    ->relationship('status', 'name'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Cliente')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('')
                            ->url(fn (Order $record) => '/admin/users/'.$record->user->user_id)
                            ->columnSpanFull()
                            ->color('gray'),
                    ]),
                Section::make('Informações do pedido')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('products')
                            ->getStateUsing(function ($record) {
                                return $record->products->sum('pivot.quantity');
                            })
                            ->label('N° de Produtos')
                            ->color('gray'),
                        TextEntry::make('total_price')
                            ->money('BRL')
                            ->label('Valor Total')
                            ->color('gray'),
                        TextEntry::make('status.name')
                            ->color(fn ($record) => OrderStatusEnum::getColor($record->status->order_status_id))
                            ->label('Status'),
                        TextEntry::make('created_at')
                            ->dateTime('d/m/y')
                            ->label('Data do Pedido')
                            ->color('gray'),
                    ]),
                Section::make('Produtos')
                    ->schema([
                        TextEntry::make('products')
                            ->getStateUsing(function ($record) {
                                $products = [];
                                foreach ($record->products as $product) {
                                    $products[] = '<a href="/admin/products/'.$product->product_id.'">'.'• '.$product->name.' ('.$product->pivot->quantity.' Unidades)'.'</a>';
                                }

                                return $products;
                            })
                            ->html()
                            ->listWithLineBreaks()
                            ->label('')
                            ->columnSpanFull()
                            ->color('gray'),
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
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
