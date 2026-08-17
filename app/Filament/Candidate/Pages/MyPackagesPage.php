<?php

namespace App\Filament\Candidate\Pages;

use App\Models\PaymentTransaction;
use App\Models\SystemSetting;
use App\Models\VivaPackage;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class MyPackagesPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static ?string $navigationLabel = 'Buy AI Credits & bKash Top-up';

    protected static ?string $title = 'AI Viva Package Store & bKash Top-up';

    protected string $view = 'filament.candidate.pages.my-packages';

    public $packages = [];

    public $merchantBkash = '';

    public $personalBkash = '';

    public $transactions = [];

    public $user;

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->packages = VivaPackage::where('is_active', true)->get();
        $this->merchantBkash = SystemSetting::get('bkash_merchant_number', '01700000000');
        $this->personalBkash = SystemSetting::get('bkash_personal_number', '01800000000');

        if ($this->user) {
            $this->transactions = PaymentTransaction::where('user_id', $this->user->id)
                ->with('package')
                ->orderBy('id', 'desc')
                ->get();
        }
    }
}
