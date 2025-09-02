<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;
    protected static ?string $navigationGroup = 'Career Management';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Job Listings';
    protected static ?string $pluralModelLabel = 'Job Listings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Basic Job Information
                Forms\Components\Section::make('Informasi Dasar Pekerjaan')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Posisi')
                            ->placeholder('e.g., Sales Engineer')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(JobListing::class, 'slug', ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->helperText('URL-friendly version of the title (auto-generated)')
                            ->dehydrateStateUsing(fn($state) => Str::slug($state))
                            ->readonly(),

                        Forms\Components\TextInput::make('department')
                            ->label('Departemen')
                            ->placeholder('e.g., Sales Marketing')
                            ->required()
                            ->maxLength(255)
                            ->datalist([
                                'Sales Marketing',
                                'Human Resources',
                                'Information Technology',
                                'Finance',
                                'Operations',
                                'Engineering',
                                'Customer Service',
                            ]),

                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi')
                            ->placeholder('e.g., Jakarta, Indonesia')
                            ->required()
                            ->maxLength(255)
                            ->datalist([
                                'Jakarta, Indonesia',
                                'Surabaya, Indonesia',
                                'Bandung, Indonesia',
                                'Medan, Indonesia',
                                'Semarang, Indonesia',
                                'Makassar, Indonesia',
                                'Remote',
                                'Hybrid',
                            ]),

                        Forms\Components\Select::make('type')
                            ->label('Tipe Pekerjaan')
                            ->options([
                                'Full-time' => 'Full-time',
                                'Part-time' => 'Part-time',
                                'Contract' => 'Contract',
                                'Internship' => 'Internship',
                                'Freelance' => 'Freelance',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Select::make('experience_level')
                            ->label('Level Pengalaman')
                            ->options([
                                'Entry Level' => 'Entry Level',
                                'Junior' => 'Junior (1-2 tahun)',
                                'Mid Level' => 'Mid Level (3-5 tahun)',
                                'Senior' => 'Senior (5+ tahun)',
                                'Manager' => 'Manager',
                                'Director' => 'Director',
                            ])
                            ->native(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Apakah lowongan ini masih dibuka?'),

                        Forms\Components\DatePicker::make('deadline')
                            ->label('Batas Waktu Aplikasi')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->helperText('Kosongkan jika tidak ada batas waktu'),
                    ])->columns(2),

                // Company Information
                Forms\Components\Section::make('Informasi Perusahaan')
                    ->schema([
                        Forms\Components\TextInput::make('company_name')
                            ->label('Nama Perusahaan')
                            ->placeholder('e.g., PT Petrotec Air Power')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if (empty($get('contact_email'))) {
                                    $domain = Str::slug($state) . '.com';
                                    $set('contact_email', 'hr@' . $domain);
                                }
                            }),

                        Forms\Components\FileUpload::make('company_logo')
                            ->label('Logo Perusahaan')
                            ->image()
                            ->disk('public_images')
                            ->directory('company-logos') // Akan simpan di public/images/company-logos/
                            ->maxSize(1024)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('200')
                            ->imageResizeTargetHeight('200'),

                        Forms\Components\Textarea::make('company_description')
                            ->label('Deskripsi Perusahaan')
                            ->placeholder('Ceritakan tentang perusahaan Anda...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                // Salary Information
                Forms\Components\Section::make('Informasi Gaji (Opsional)')
                    ->schema([
                        Forms\Components\TextInput::make('salary_min')
                            ->label('Gaji Minimum')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('5000000'),

                        Forms\Components\TextInput::make('salary_max')
                            ->label('Gaji Maksimum')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('8000000'),

                        Forms\Components\Select::make('salary_type')
                            ->label('Periode Gaji')
                            ->options([
                                'monthly' => 'Per Bulan',
                                'yearly' => 'Per Tahun',
                                'hourly' => 'Per Jam',
                                'project' => 'Per Proyek',
                            ])
                            ->default('monthly')
                            ->native(false),

                        Forms\Components\Toggle::make('salary_negotiable')
                            ->label('Dapat Dinegosiasi')
                            ->default(false),
                    ])->columns(2)->collapsible(),

                // Job Details
                Forms\Components\Section::make('Detail Pekerjaan')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Pekerjaan')
                            ->placeholder('Deskripsi singkat tentang posisi ini dan perusahaan...')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                                'undo',
                                'redo',
                            ]),

                        Forms\Components\RichEditor::make('responsibilities')
                            ->label('Tugas dan Tanggung Jawab')
                            ->placeholder('Masukkan tugas-tugas dalam bentuk list...')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'bulletList',
                                'orderedList',
                                'undo',
                                'redo',
                            ]),

                        Forms\Components\RichEditor::make('requirements')
                            ->label('Kualifikasi yang Dibutuhkan')
                            ->placeholder('Masukkan kualifikasi dalam bentuk list...')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'bulletList',
                                'orderedList',
                                'undo',
                                'redo',
                            ]),

                        Forms\Components\RichEditor::make('benefits')
                            ->label('Fasilitas dan Benefit')
                            ->placeholder('Masukkan benefit dalam bentuk list...')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'bulletList',
                                'orderedList',
                                'undo',
                                'redo',
                            ]),
                    ])->columnSpanFull(),

                // Contact Information
                Forms\Components\Section::make('Informasi Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email untuk Aplikasi')
                            ->placeholder('hr@company.com')
                            ->email()
                            ->helperText('Email akan otomatis terisi berdasarkan nama perusahaan'),

                        Forms\Components\TextInput::make('contact_phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->placeholder('+62 21 1234 5678'),

                        Forms\Components\Textarea::make('application_note')
                            ->label('Catatan Aplikasi')
                            ->placeholder('Segera apply jika Anda tertarik dan berminat untuk posisi ini...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('company_logo')
                    ->label('Logo')
                    ->circular()
                    ->size(50)
                    ->getStateUsing(function ($record) {
                        if ($record->company_logo) {
                            return asset('images/' . $record->company_logo);
                        }
                        return null;
                    })
                    ->defaultImageUrl(asset('images/logo_indo.png')) // Default image jika tidak ada logo
                    ->tooltip(fn($record) => $record->company_name),

                Tables\Columns\TextColumn::make('title')
                    ->label('Posisi')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->wrap()
                    ->description(fn($record) => $record->company_name)
                    ->tooltip(fn($record) => $record->title),

                Tables\Columns\TextColumn::make('department')
                    ->label('Departemen')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-map-pin')
                    ->limit(20),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Full-time' => 'success',
                        'Part-time' => 'warning',
                        'Contract' => 'info',
                        'Internship' => 'gray',
                        'Freelance' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('experience_level')
                    ->label('Level')
                    ->badge()
                    ->color('primary')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn($state) => $state && now()->diffInDays($state, false) < 7 ? 'danger' : 'gray')
                    ->icon(fn($state) => $state && now()->diffInDays($state, false) < 7 ? 'heroicon-m-exclamation-triangle' : null)
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('salary_range')
                    ->label('Gaji')
                    ->getStateUsing(function ($record) {
                        if ($record->salary_min || $record->salary_max) {
                            $min = $record->salary_min ? 'Rp ' . number_format($record->salary_min, 0, ',', '.') : '';
                            $max = $record->salary_max ? 'Rp ' . number_format($record->salary_max, 0, ',', '.') : '';

                            if ($min && $max) {
                                return $min . ' - ' . $max;
                            }
                            return $min ?: $max;
                        }
                        return $record->salary_negotiable ? 'Nego' : '-';
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe Pekerjaan')
                    ->options([
                        'Full-time' => 'Full-time',
                        'Part-time' => 'Part-time',
                        'Contract' => 'Contract',
                        'Internship' => 'Internship',
                        'Freelance' => 'Freelance',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('department')
                    ->label('Departemen')
                    ->options(fn() => JobListing::query()->pluck('department', 'department')->toArray())
                    ->multiple(),

                Tables\Filters\SelectFilter::make('location')
                    ->label('Lokasi')
                    ->options(fn() => JobListing::query()->pluck('location', 'location')->toArray())
                    ->multiple(),

                Tables\Filters\SelectFilter::make('experience_level')
                    ->label('Level Pengalaman')
                    ->options([
                        'Entry Level' => 'Entry Level',
                        'Junior' => 'Junior',
                        'Mid Level' => 'Mid Level',
                        'Senior' => 'Senior',
                        'Manager' => 'Manager',
                        'Director' => 'Director',
                    ])
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif')
                    ->native(false),

                Tables\Filters\Filter::make('deadline')
                    ->label('Deadline Mendekat')
                    ->query(fn(Builder $query): Builder => $query->where('deadline', '>=', now())->where('deadline', '<=', now()->addDays(7)))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ReplicateAction::make()
                        ->beforeReplicaSaved(function (JobListing $replica): void {
                            $replica->slug = $replica->slug . '-copy-' . now()->format('YmdHis');
                            $replica->is_active = false;
                        }),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['is_active' => true]))),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['is_active' => false]))),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('title')
                            ->label('')
                            ->size('xl')
                            ->weight('bold')
                            ->color('primary'),

                        TextEntry::make('company_name')
                            ->label('')
                            ->size('lg')
                            ->color('gray'),
                    ])
                    ->columns(1),

                Section::make('Informasi Dasar')
                    ->schema([
                        ImageEntry::make('company_logo')
                            ->label('Logo Perusahaan')
                            ->height(100)
                            ->width(100)
                            ->circular(),

                        TextEntry::make('department')
                            ->label('Departemen')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('location')
                            ->label('Lokasi')
                            ->icon('heroicon-m-map-pin'),

                        TextEntry::make('type')
                            ->label('Tipe Pekerjaan')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Full-time' => 'success',
                                'Part-time' => 'warning',
                                'Contract' => 'info',
                                'Internship' => 'gray',
                                'Freelance' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('experience_level')
                            ->label('Level Pengalaman')
                            ->badge()
                            ->color('primary'),

                        TextEntry::make('deadline')
                            ->label('Deadline')
                            ->date('d F Y')
                            ->color(fn($state) => $state && now()->diffInDays($state, false) < 7 ? 'danger' : 'gray'),

                        TextEntry::make('is_active')
                            ->label('Status')
                            ->badge()
                            ->getStateUsing(fn($record) => $record->is_active ? 'Aktif' : 'Nonaktif')
                            ->color(fn(string $state): string => $state === 'Aktif' ? 'success' : 'danger'),

                        TextEntry::make('salary_display')
                            ->label('Gaji')
                            ->getStateUsing(function ($record) {
                                if ($record->salary_min || $record->salary_max) {
                                    $min = $record->salary_min ? 'Rp ' . number_format($record->salary_min, 0, ',', '.') : '';
                                    $max = $record->salary_max ? 'Rp ' . number_format($record->salary_max, 0, ',', '.') : '';

                                    if ($min && $max) {
                                        return $min . ' - ' . $max . ' / ' . ($record->salary_type ?? 'bulan');
                                    }
                                    return ($min ?: $max) . ' / ' . ($record->salary_type ?? 'bulan');
                                }
                                return $record->salary_negotiable ? 'Dapat dinegosiasi' : 'Tidak disebutkan';
                            }),
                    ])->columns(3),

                Section::make('Deskripsi Perusahaan')
                    ->schema([
                        TextEntry::make('company_description')
                            ->label('')
                            ->prose()
                            ->markdown(),
                    ])
                    ->visible(fn($record) => !empty($record->company_description)),

                Section::make('Deskripsi Pekerjaan')
                    ->schema([
                        TextEntry::make('description')
                            ->label('')
                            ->prose()
                            ->html(),
                    ]),

                Section::make('Tugas dan Tanggung Jawab')
                    ->schema([
                        TextEntry::make('responsibilities')
                            ->label('')
                            ->prose()
                            ->html(),
                    ])
                    ->visible(fn($record) => !empty($record->responsibilities)),

                Section::make('Kualifikasi yang Dibutuhkan')
                    ->schema([
                        TextEntry::make('requirements')
                            ->label('')
                            ->prose()
                            ->html(),
                    ]),

                Section::make('Fasilitas dan Benefit')
                    ->schema([
                        TextEntry::make('benefits')
                            ->label('')
                            ->prose()
                            ->html(),
                    ])
                    ->visible(fn($record) => !empty($record->benefits)),

                Section::make('Informasi Kontak')
                    ->schema([
                        TextEntry::make('contact_email')
                            ->label('Email untuk Aplikasi')
                            ->copyable()
                            ->copyMessage('Email disalin!')
                            ->icon('heroicon-m-envelope'),

                        TextEntry::make('contact_phone')
                            ->label('Nomor Telepon')
                            ->copyable()
                            ->copyMessage('Nomor telepon disalin!')
                            ->icon('heroicon-m-phone')
                            ->url(fn($state) => $state ? "tel:{$state}" : null),

                        TextEntry::make('application_note')
                            ->label('Catatan Aplikasi')
                            ->prose()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn($record) => !empty($record->contact_email) || !empty($record->contact_phone) || !empty($record->application_note)),

                Section::make('Informasi Sistem')
                    ->schema([
                        TextEntry::make('slug')
                            ->label('Slug URL')
                            ->copyable(),

                        TextEntry::make('created_at')
                            ->label('Dibuat pada')
                            ->dateTime('d F Y, H:i'),

                        TextEntry::make('updated_at')
                            ->label('Diperbarui pada')
                            ->dateTime('d F Y, H:i'),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(),
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
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            // 'view' => Pages\ViewJobListing::route('/{record}'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['company_name']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'company_name', 'department', 'location'];
    }
}