<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\ProductVariationTypeEnum;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
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
              $types = $this->record->variationTypes;
              $fields = [];

              foreach ($types as $type) {
                     $fields[] = TextInput::make('variation_type_' . ($type->id) . '.id')
                            ->hidden();

                     $fields[] = TextInput::make('variation_type_' . ($type->id) . '.name')
                            ->label($type->name);
              }

              return $form
                     ->schema([
                            Repeater::make('variations')
                                   ->label(false)
                                   ->collapsible()
                                   ->addable(false)
                                   ->defaultItems(1)
                                   ->schema([
                                          Section::make()
                                                 ->schema($fields)
                                                 ->columns(3),
                                          TextInput::make('quan tity')
                                                 ->label('Quantity')
                                                 ->numeric(),
                                          TextInput::make('price')
                                                 ->label('Price')
                                                 ->numeric()
                                   ])
                                   ->columns(2)
                                   ->columnSpan(2)
                     ]);
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

       private function mergeCartesianWithExisting($variationTypes, $existingData): array
       {
              $defaultQuantity = $this->record->quantity;
              $defaultPrice = $this->record->price;
              $cartesianProduct = $this->cartesianProduct($variationTypes, $defaultQuantity);
              $mergedResult = [];

              foreach ($cartesianProduct as $product) {
                     // Extract option IDs from the currect product combination as an array

                     $optionIds = collect($product)
                            ->filter(fn($value, $key) => str_starts_with($key, 'variation_type_'))
                            ->map(fn($option) => $option['id'])
                            ->values()
                            ->toArray();

                     // Find matching entry in existing data
                     $match = array_filter($existingData, function ($existingOption) use ($optionIds) {
                            return $existingOption['variation_type_option_ids'] === $optionIds;
                     });

                     // If match found overide quantity and price
                     if (!empty($match)) {
                            $existingEntry = reset($match);
                            $product['quantity'] = $existingEntry['quantity'];
                            $product['price'] = $existingEntry['price'];
                     } else {
                            // Set default quantity and price if no match
                            $product['quantity'] = $defaultQuantity;
                            $product['price'] = $defaultPrice;;
                     }

                     $mergedResult[] = $product;
              }

              return $mergedResult;
       }

       private function cartesianProduct($variationTypes, $defaultQuantity = null, $defaultPrice = null): array
       {
              $result = [[]];

              foreach ($variationTypes as $index => $variationType) {
                     $temp = [];

                     foreach ($variationType->options as $option) {
                            // Add the current option to all existing combination
                            foreach ($result as $combination) {
                                   $newCombination = $combination + [
                                          'variation_type_' . ($variationType->id) => [
                                                 'id' => $option->id,
                                                 'name' => $option->name,
                                                 'label' => $variationType->name,
                                          ],
                                   ];

                                   $temp[] = $newCombination;
                            }
                     }

                     $result = $temp; // Update results with the new combination 
              }

              // Add quantity and price to completed combinations
              foreach ($result as &$combination) {
                     if (count($combination) === count($variationTypes)) {
                            $combination['quantity'] = $defaultQuantity;
                            $combination['price'] = $defaultPrice;
                     }
              }

              return $result;
       }

       protected function mutateFormDataBeforeSave(array $data): array
       {
              // Initialize an array to hold the formatted data
              $formattedData = [];

              // Loop through each variation to restructure it 
              foreach ($data['variations'] as $option) {
                     $variationTypeOptionIds = [];
              }

              return $data;
       }
}
