<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Model EventTemplate
 * Reprezentuje szablon wydarzenia w systemie.
 *
 * @property int $id
 * @property string $name
 * @property string|null $subtitle
 * @property string $slug
 * @property int $duration_days
 * @property bool $is_active
 * @property string|null $featured_image
 * @property string|null $event_description
 * @property array|null $gallery
 * @property string|null $office_description
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */


class EventTemplate extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Automatyczne zapewnienie unikalności slugów przy tworzeniu/aktualizacji.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Jeśli slug nie jest ustawiony, generuj z nazwy
            $baseSlug = $model->slug ?: Str::slug($model->name);
            $slug = $baseSlug;
            $i = 1;

            // Sprawdzaj unikalność (ignoruj aktualny rekord przy edycji)
            while (static::where('slug', $slug)
                ->when($model->exists, fn($q) => $q->where('id', '!=', $model->id))
                ->exists()) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }
            $model->slug = $slug;
        });
    }

    /**
     * Casty atrybutów.
     */
    protected $casts = [
        'gallery' => 'array',
        'is_active' => 'boolean',
    ];


    /**
     * Mutator: zawsze zapisuj featured_image jako string (pierwszy element tablicy lub null)
     */
    public function setFeaturedImageAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['featured_image'] = $value[0] ?? null;
        } else {
            $this->attributes['featured_image'] = $value;
        }
    }

    /**
     * Accessor: zwracaj pełną ścieżkę względną względem dysku dla featured_image,
     * jeśli w bazie zapisany jest sam basename.
     */
    public function getFeaturedImageAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }

        // Jeśli już jest ścieżka z katalogiem, zostaw bez zmian
        if (is_string($value) && str_contains($value, '/')) {
            return $value;
        }

        // W przeciwnym razie dołóż domyślny katalog dla miniatur
        return 'event-templates/' . ltrim((string) $value, '/');
    }

    /**
     * Accessor: zwracaj tablicę ścieżek dla galerii i dopilnuj, by elementy
     * miały prefiks katalogu, jeśli w bazie zapisane są same nazwy plików.
     */
    public function getGalleryAttribute($value)
    {
        // Upewnij się, że mamy tablicę
        $items = $value;
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $items = is_array($decoded) ? $decoded : [];
        } elseif (!is_array($value)) {
            $items = [];
        }

        return array_map(function ($path) {
            if (empty($path)) {
                return $path;
            }
            if (is_string($path) && str_contains($path, '/')) {
                return $path;
            }
            return 'event-templates/gallery/' . ltrim((string) $path, '/');
        }, $items);
    }

    /**
     * Relacja wiele-do-wielu z tagami
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'event_template_tag');
    }

    public function transportTypes()
    {
        return $this->belongsToMany(TransportType::class);
    }

    public function eventTypes()
    {
        return $this->belongsToMany(EventType::class);
    }

    public function startPlace()
    {
        return $this->belongsTo(Place::class, 'start_place_id');
    }

    public function endPlace()
    {
        return $this->belongsTo(Place::class, 'end_place_id');
    }

    // Relacja: jeden event_template może mieć jeden event_price_description (pivot, nullable)
    public function eventPriceDescription()
    {
        return $this->belongsToMany(
            \App\Models\EventPriceDescription::class,
            'event_template_event_price_description',
            'event_template_id',
            'event_price_description_id'
        );
    }

    /**
     * Pola masowo przypisywalne
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'subtitle',
        'slug',
        'duration_days',
        'is_active',
        'featured_image',
        'event_description',
        'gallery',
        'office_description',
        'notes',
        'transfer_km',
        'program_km',
        'bus_id',
        'transport_notes',
        'markup_id', // dodajemy pole do przypisania narzutu
        'start_place_id',
        'end_place_id',
        'show_title_style',
        'show_description',
        'name',
        'subtitle',
        'slug',
        'duration_days',
        'is_active',
        'featured_image',
        'event_description',
        'gallery',
        'office_description',
        'notes',
        'transfer_km',
        'program_km',
        'bus_id',
        'markup_id',
        'start_place_id',
        'end_place_id',
        'transport_notes',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'seo_canonical',
        'seo_og_title',
        'seo_og_description',
        'seo_og_image',
        // usunięte: 'seo_twitter_title', 'seo_twitter_description', 'seo_twitter_image', 'seo_schema', 'transfer_km2', 'program_km2'
        // usunięte: 'transfer_km2', 'program_km2'
        // usunięte: 'seo_twitter_title', 'seo_twitter_description', 'seo_twitter_image', 'seo_schema'
    ];

    /**
     * Relacja wiele-do-wielu z punktami programu (tymczasowa implementacja)
     */
    public function programPoints()
    {
        return $this->belongsToMany(\App\Models\EventTemplateProgramPoint::class, 'event_template_event_template_program_point')
            ->withPivot([
                'id',
                'day',
                'order',
                'notes',
                'include_in_program',
                'include_in_calculation',
                'active',
                'show_title_style',
                'show_description',
            ]);
    }

    /**
     * Relacja wiele-do-wielu z podpunktami programu (pivot z właściwościami)
     */
    public function programPointChildren()
    {
        return $this->belongsToMany(
            \App\Models\EventTemplateProgramPoint::class,
            'event_template_program_point_child_pivot',
            'event_template_id',
            'program_point_child_id'
        )
            ->withPivot([
                'id',
                'include_in_program',
                'include_in_calculation',
                'active',
                'created_at',
                'updated_at',
            ]);
    }

    /**
     * Relacja jeden-do-wielu z wariantami ilości uczestników
     */
    public function qtyVariants()
    {
        return $this->hasMany(EventTemplateQty::class);
    }

    /**
     * Relacja jeden-do-wielu z cenami za osobę
     */
    public function pricesPerPerson()
    {
        return $this->hasMany(EventTemplatePricePerPerson::class);
    }

    /**
     * Ubezpieczenie przypisane do każdego dnia (event_template_day_insurance)
     */
    public function dayInsurances()
    {
        return $this->hasMany(\App\Models\EventTemplateDayInsurance::class);
    }

    /**
     * Pobierz ubezpieczenie dla danego dnia (lub null)
     */
    public function getInsuranceForDay($day)
    {
        return $this->dayInsurances()->where('day', $day)->first()?->insurance;
    }

    /**
     * Relacja wiele-do-jednego z tabelą bus
     */
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    /**
     * Relacja dni hotelowych (noclegów) dla eventu
     */
    public function hotelDays()
    {
        return $this->hasMany(EventTemplateHotelDay::class);
    }

    /**
     * Relacja wiele-do-jednego z tabelą markup
     */
    public function markup()
    {
        return $this->belongsTo(Markup::class);
    }

    /**
     * Relacja jeden-do-wielu z imprezami utworzonymi z tego szablonu
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Scope dla aktywnych szablonów
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope dla nieaktywnych szablonów
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Relacja jeden-do-wielu z dostępnością miejsc startowych
     */
    public function startingPlaceAvailabilities()
    {
        return $this->hasMany(\App\Models\EventTemplateStartingPlaceAvailability::class);
    }

    /**
     * Relacja wiele-do-wielu z podatkami
     */
    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'event_template_tax');
    }

    /**
     * Build canonical pretty URL for this event template.
    * Pattern: /{region-name}/{duration}-dniowe/{id}/{slug}
     * Region currently derived from cookie/default (no Region model present) -> 'region'
     */
    public function prettyUrl(?int $startPlaceId = null): string
    {
        $effectiveStartPlaceId = $startPlaceId
            ?: (request()->cookie('start_place_id') ? (int) request()->cookie('start_place_id') : null)
            ?: (isset($GLOBALS['current_start_place_id']) ? (int)$GLOBALS['current_start_place_id'] : null);

        $regionSlug = 'region';
        if ($effectiveStartPlaceId) {
            $place = \App\Models\Place::find($effectiveStartPlaceId);
            if ($place) {
                $regionSlug = Str::slug($place->name);
            }
        } elseif (function_exists('request') && request()->route('regionSlug')) {
            $regionSlug = request()->route('regionSlug');
        }

        $dayLength = ($this->duration_days ?? 0) . '-dniowe';
        $slug = $this->slug ?: Str::slug($this->name);
        return route('package.pretty', compact('regionSlug', 'dayLength', 'slug') + ['id' => $this->id]);
    }
}
