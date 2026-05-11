<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Listing extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_SOLD = 'sold';

    public const CONDITION_VERY_GOOD = 'very good';
    public const CONDITION_GOOD = 'good';
    public const CONDITION_BAD = 'bad';
    public const CONDITION_VERY_BAD = 'very bad';

    public const SIZE_OPTIONS = ['XS', 'S', 'M', 'L', 'XL'];
    public const CONDITION_OPTIONS = [
        self::CONDITION_VERY_GOOD,
        self::CONDITION_GOOD,
        self::CONDITION_BAD,
        self::CONDITION_VERY_BAD,
    ];
    public const SORT_OPTIONS = ['newest', 'oldest', 'price_asc', 'price_desc'];

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'condition',
        'size',
        'status',
    ];

    protected $appends = [
        'primary_image_url',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ListingImage::class)->where('is_primary', true);
    }

    public function scopeVisible(Builder $query): void
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeOwnedBy(Builder $query, User $user): void
    {
        $query->where('user_id', $user->id);
    }

    public function scopeApplyFilters(Builder $query, array $filters): void
    {
        $query
            ->when($filters['search'] ?? null, function (Builder $builder, string $search): void {
                $searchTerm = '%'.Str::lower($search).'%';

                $builder->where(function (Builder $nestedBuilder) use ($searchTerm): void {
                    $nestedBuilder
                        ->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                        ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
                });
            })
            ->when($filters['category_id'] ?? null, fn (Builder $builder, int|string $categoryId) => $builder->where('category_id', $categoryId))
            ->when($filters['price_min'] ?? null, fn (Builder $builder, int|float|string $priceMin) => $builder->where('price', '>=', $priceMin))
            ->when($filters['price_max'] ?? null, fn (Builder $builder, int|float|string $priceMax) => $builder->where('price', '<=', $priceMax))
            ->when($filters['size'] ?? null, fn (Builder $builder, string $size) => $builder->where('size', $size))
            ->when($filters['condition'] ?? null, fn (Builder $builder, string $condition) => $builder->where('condition', $condition));
    }

    public function scopeApplySorting(Builder $query, ?string $sort): void
    {
        match ($sort) {
            'oldest' => $query->oldest(),
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default => $query->latest(),
        };
    }

    public function replaceImages(array $uploadedFiles): void
    {
        $this->deleteImageFiles();

        foreach ($uploadedFiles as $index => $uploadedFile) {
            if (! $uploadedFile instanceof UploadedFile) {
                continue;
            }

            $path = $uploadedFile->store('listings', 'public');

            $this->images()->create([
                'path' => $path,
                'is_primary' => $index === 0,
            ]);
        }

        $this->load('images', 'primaryImage');
    }

    public function deleteImageFiles(): void
    {
        $this->loadMissing('images');

        foreach ($this->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $this->images()->delete();
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        $path = $this->primaryImage?->path ?? $this->images->first()?->path;

        return $path ? Storage::url($path) : null;
    }
}
