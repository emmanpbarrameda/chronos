<?php

namespace Ianstudios\Chronos\Actions;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ChronosHistoryAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'chronosHistory';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('History Log')
            ->icon('heroicon-m-clock')
            ->color('gray')
            ->modalHeading('Chronos Audit Trail')
            ->modalSubmitAction(false) // View only
            ->modalCancelAction(false)
            ->slideOver()
            ->modalContent(fn (Model $record) => view('chronos::history-modal', [
                'audits' => $record->audits()->with('user')->get()
            ]));
    }
}