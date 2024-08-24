<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Product;

use Filament\Forms\Get;
use Filament\Forms\Set;

use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->required()
                    ->relationship('customer','name'),
                Forms\Components\TextInput::make('order_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('order_date')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('order_status')
                    ->required()
                    ->options(OrderStatus::class)
                    ->default('APPOINTMENT'),
                Forms\Components\Select::make('payment_method')
                    ->required()
                    ->live()
                    ->options(PaymentMethod::class)
                    ->default('CASH'),
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(100)
                    ->live(debounce:500)
                    ->afterStateUpdated(function(Set $set, Get $get){
                        // $set('order_number', $get('total_amount'));
                    })
                    ->disabled(),
                Forms\Components\Repeater::make('orderItems')
                    ->relationship()
                    ->columnSpanFull()
                    ->columns(5)
                    ->schema([
                    Forms\Components\Select::make('product_id')
                    ->relationship('product','name')
                    ->live(debounce:500)
                    ->afterStateUpdated(function(Set $set, Get $get){

                        $product = Product::where('id', $get('product_id'))->first();

                        // dd($product);

                        $unit_price = $product ? $product->price : 0;
                        
                        $set('unit_price', $unit_price);
                        
                        // dd($get('../../payment_method'));                    
                        
                        self::updateOrderItemAmount($set, $get);
                        self::updateOrderTotal($set, $get);

                    })
                    ->required(),
                    Forms\Components\TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->live(debounce:500)
                    ->afterStateUpdated(function(Set $set, Get $get){
                        self::updateOrderItemAmount($set, $get);
                        // self::updateOrderTotal($set, $get);
                    }),
                    Forms\Components\TextInput::make('unit_price')
                    ->required()
                    ->numeric()
                    ->disabled()
                    ->live(debounce:500)
                    ->afterStateUpdated(function(Set $set, Get $get){
                        self::updateOrderItemAmount($set, $get);
                        // self::updateOrderTotal($set, $get);
                    }),
                    Forms\Components\TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        
                        self::updateOrderItemAmount($set, $get);
                        // self::updateOrderTotal($set, $get);
                    }),

                    Forms\Components\TextInput::make('amount')
                        ->required()
                        ->disabled()
                        ->numeric(),
                    
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('View invoice')
                    ->url(fn (Order $record): string => route('invoice.stream-pdf', $record->id))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('Download invoice')
                    ->url(fn (Order $record): string => route('invoice.download-pdf', $record->id))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('Email invoice')
                    ->url(fn (Order $record): string => route('invoice.send-email', $record->id))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    protected static function updateOrderItemAmount(Set $set, Get $get)
    {
        $qty = (int) $get('qty');
        $unit_price = (int) $get('unit_price');
        $discount = (int) $get('discount');

        $amount = $qty * $unit_price;
        if ($discount > 0) {
            $amount -= ($amount * $discount / 100);
        }
        $set('amount', $amount);
    }

    protected static function updateOrderTotal(Set $set, Get $get)
    {
        $totalAmount = 0;

        // dd($get('../../total_amount'));
        // dd($get('../../orderItems'));
        
        // Default to an empty array if null
        $orderItems = $get('../../orderItems') ?? [];
        
        // Debugging to check the value of $orderItems
        // dd($orderItems);

        // Ensure $orderItems is an array before using array_reduce
        if (is_array($orderItems)) {
            $total_amount = array_reduce($orderItems, function($carry, $item) {
                return $carry + ($item['amount'] ?? 0);
            }, 0);
            $set('../../total_amount', $total_amount);
        } else {
            // Handle the case where $orderItems is not an array
            $set('../../total_amount', 0);
        }
    }
}
