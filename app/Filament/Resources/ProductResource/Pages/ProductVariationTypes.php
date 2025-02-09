<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\Action;

class ProductVariationTypes extends EditRecord
{
       protected static string $resource = ProductResource::class;
       protected static ?string $navigationIcon = 'heroicon-c-photo';

       public function form(Form $form): Form
       {
              return $form
                     ->schema([]);
       }

       protected function getHeaderActions(): array
       {
              return [
                     DeleteAction::make()
              ];
       }
}
