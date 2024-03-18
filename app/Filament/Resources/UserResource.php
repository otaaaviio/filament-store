<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatusEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Cliente';

    public static function table(Table $table): Table
    {
        return $table
            ->toggleColumnsTriggerAction(function ($action) {
                return $action->button()->label('Colunas');
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data de registro')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->label(''),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informações do Usuário')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome')
                            ->color('gray'),
                        TextEntry::make('email')
                            ->color('gray'),
                        TextEntry::make('created_at')
                            ->getStateUsing(fn ($record) => $record->created_at->format('d/m/Y'))
                            ->label('Data de registro'),
                        TextEntry::make('N° de produtos comprados')
                            ->getStateUsing(fn ($record) => $record->orders->where('order_status', OrderStatusEnum::DELIVERED)->count())
                            ->color('gray'),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderRelationManager::class,
            RelationManagers\ProductReviewRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
