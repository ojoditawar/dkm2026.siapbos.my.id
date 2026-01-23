<?php

namespace App\Filament\Resources\Tugas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Malzariey\FilamentLexicalEditor\Enums\ToolbarItem;
use Malzariey\FilamentLexicalEditor\LexicalEditor;

class TugasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('struktur_kode')
                    ->relationship('struktur', 'nama')
                    ->required(),
                LexicalEditor::make('uraian')
                    ->enabledToolbars([
                        ToolbarItem::UNDO,
                        ToolbarItem::REDO,
                        ToolbarItem::FONT_FAMILY,
                        ToolbarItem::FONT_SIZE,
                        ToolbarItem::BOLD,
                        ToolbarItem::ITALIC,
                        ToolbarItem::NORMAL,
                        ToolbarItem::H1,
                        ToolbarItem::H2,
                        ToolbarItem::H3,
                        ToolbarItem::H4,
                        ToolbarItem::H5,
                        ToolbarItem::H6,
                        ToolbarItem::BULLET,
                        ToolbarItem::NUMBERED,
                        ToolbarItem::QUOTE,
                        ToolbarItem::CODE,
                        ToolbarItem::UNDERLINE,
                        ToolbarItem::ICODE,
                        ToolbarItem::LINK,
                        ToolbarItem::TEXT_COLOR,
                        ToolbarItem::BACKGROUND_COLOR,
                        ToolbarItem::LOWERCASE,
                        ToolbarItem::UPPERCASE,
                        ToolbarItem::CAPITALIZE,
                        ToolbarItem::STRIKETHROUGH,
                        ToolbarItem::SUBSCRIPT,
                        ToolbarItem::SUPERSCRIPT,
                        ToolbarItem::CLEAR,
                        ToolbarItem::LEFT,
                        ToolbarItem::CENTER,
                        ToolbarItem::RIGHT,
                        ToolbarItem::JUSTIFY,
                        ToolbarItem::START,
                        ToolbarItem::END,
                        ToolbarItem::INDENT,
                        ToolbarItem::OUTDENT,
                        ToolbarItem::HR,
                        ToolbarItem::IMAGE
                    ])
                    ->required(),
            ]);
    }
}
