<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\ProductVariationTypeEnum;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\Action;

class ProductVariations extends EditRecord
{
       protected static string $resource = ProductResource::class;

       protected static ?string $title = 'Variations';
       protected static ?string $navigationIcon = 'heroicon-c-clipboard-document-list';

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

       protected function mutateFormDataBeforeFill(array $data): array
       {
              $variations = $this->record->variations->toArray();
              $data['variations'] = $this->mergeCartesianWithExisting($this->record->variationTypes, $variations);

              return $data;
       }
}
