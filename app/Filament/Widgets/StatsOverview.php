<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Pedidos', Order::count())
            ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('Total de Clientes Cadastrados', User::count() - 1)
            ->icon('heroicon-o-users'),
            Stat::make('Total de Produtos Cadastrados', Product::count())
            ->icon('heroicon-o-archive-box'),
            Stat::make('Média de Avaliações', str_repeat('⭐ ', round(ProductReview::avg('rating'))))
            ->icon('heroicon-o-star')
        ];
    }
}
