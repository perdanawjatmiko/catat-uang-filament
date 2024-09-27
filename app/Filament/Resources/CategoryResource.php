<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Category Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('parent_id')
                    ->options(Category::where('parent_id', null)->pluck('name', 'id'))
                    ->label('Parent'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Category Name')
                    ->description(fn (Category $record): string => $record->description ?? '')
                    ->searchable()
                    ->weight(function ($record) {
                        return is_null($record->parent_id) ? 'bold' : 'normal';
                    })
                    ->color(function ($record) {
                        return $record->parent_id ? '' : 'primary';
                    })
                    ->size(function ($record){
                        return $record->parent_id? 'sm' : 'large';
                    })
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable()
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->badge()
                    ->label('Parent')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->disabledClick(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->query(function (Category $category) {
                $parents = Category::whereNull('parent_id')->get();
                $orderedCategories = [];
                
                foreach ($parents as $parent) {
                    $orderedCategories[] = $parent;
                    $children = Category::where('parent_id', $parent->id)->get();
                    foreach ($children as $child) {
                        $orderedCategories[] = $child;
                    }
                }
                return $category->whereIn('id', collect($orderedCategories)->pluck('id'));
            })
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
