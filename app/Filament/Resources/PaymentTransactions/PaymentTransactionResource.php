<?php

namespace App\Filament\Resources\PaymentTransactions;

use App\Filament\Resources\PaymentTransactions\Pages\ListPaymentTransactions;
use App\Models\PaymentTransaction;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PaymentTransactionResource extends Resource
{
    protected static ?string $model = PaymentTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static UnitEnum|string|null $navigationGroup = 'Monetization & Billing';

    protected static ?string $navigationLabel = 'bKash Payments & Approvals';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Candidate')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('package.name')
                    ->label('Package Purchased')
                    ->default('N/A'),

                TextColumn::make('amount_bdt')
                    ->label('Amount (BDT)')
                    ->money('BDT')
                    ->sortable(),

                TextColumn::make('bkash_number')
                    ->label('bKash Account')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('trx_id')
                    ->label('TrxID')
                    ->searchable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Submitted Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve & Grant Credits')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->hidden(fn (PaymentTransaction $record): bool => $record->status !== 'pending')
                    ->action(function (PaymentTransaction $record) {
                        $user = $record->user;
                        $package = $record->package;

                        if ($user && $package) {
                            if ($package->type === 'ai_mock') {
                                $user->increment('ai_viva_credits', $package->credits);
                            }
                        }

                        $record->update([
                            'status' => 'approved',
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Payment Approved')
                            ->body("Approved TrxID {$record->trx_id} and granted {$package?->credits} credits to {$user?->name}!")
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        TextInput::make('rejection_reason')
                            ->label('Reason for Rejection')
                            ->placeholder('Invalid TrxID or amount discrepancy')
                            ->required(),
                    ])
                    ->hidden(fn (PaymentTransaction $record): bool => $record->status !== 'pending')
                    ->action(function (PaymentTransaction $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'rejection_reason' => $data['rejection_reason'] ?? 'Invalid TrxID',
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);

                        Notification::make()
                            ->warning()
                            ->title('Payment Rejected')
                            ->body("Payment TrxID {$record->trx_id} was rejected.")
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPaymentTransactions::route('/'),
        ];
    }
}
