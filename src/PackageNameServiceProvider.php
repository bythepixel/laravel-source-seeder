<?php

namespace PackageName;

use Illuminate\Support\ServiceProvider;

/**
 * Class PackageNameServiceProvider
 * @package NovaPageElements
 *
 * @note This class should be renamed to match your Package.
 * @note If your package is named NovaPageElements, this class should be named NovaPageElementsServiceProvider
 * @note If your package is named NovaPageElements, this class file should be named NovaPageElementsServiceProvider.php
 * @note Additionally, `PackageNameServiceProvider::tag` should be changed to a relevant name for your package. For a
 * Package named NovaPageElements, the value is set to `nova-page-elements`.
 */
class PackageNameServiceProvider extends ServiceProvider
{
    /**
     * The Publishing "Tag" associated to this Package (used as a constant for config file name, views, etc.)
     */
    public string $tag = 'package-name';

    /**
     * Bootstrap Package Service(s), which most-notably includes configuring Package Publishing
     */
    public function boot()
    {
        // Publish Package Assets
        /*
        $this->publishes([
            __DIR__ . '/../resources/assets' => resource_path('assets'),
        ], 'assets');
        */

        // Publish Package Configuration
        /*
        $this->publishes([
            __DIR__ . "/../config/$this->tag.php" => config_path("$this->tag.php"),
        ], 'config');
        */

        // Load Package Migrations
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load Package Views (Application Views at `resources/vendor/package-name/` override Package Views)
        // $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->tag);

        // Load Package View Components
        /*
        $this->loadViewComponentsAs($this->tag, [
            AccentedHeading::class,
            ArrowButton::class,
            BlogCard::class,
            Button::class,
            CollapsibleText::class,
            ResponsiveImage::class,
            SectionCarouselTestimonials::class,
            SectionFaqs::class,
            SectionGeneralSlider::class,
            SectionImageSliderWithCaptions::class,
            SectionSummaryFaq::class,
        ]);
        */
    }

    /**
     * Register Package Service(s)
     */
    public function register()
    {

    }
}
