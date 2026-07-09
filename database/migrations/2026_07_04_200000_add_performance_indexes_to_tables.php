<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Services table indexes
        Schema::table('services', function (Blueprint $table) {
            if (!$this->hasIndex('services', 'services_slug_index')) {
                $table->index('slug');
            }
            if (!$this->hasIndex('services', 'services_is_active_order_index')) {
                $table->index(['is_active', 'order']);
            }
        });

        // Articles table indexes
        Schema::table('articles', function (Blueprint $table) {
            if (!$this->hasIndex('articles', 'articles_slug_index')) {
                $table->index('slug');
            }
            if (!$this->hasIndex('articles', 'articles_is_published_created_at_index')) {
                $table->index(['is_published', 'created_at']);
            }
        });

        // Gallery projects table indexes
        Schema::table('gallery_projects', function (Blueprint $table) {
            if (!$this->hasIndex('gallery_projects', 'gallery_projects_slug_index')) {
                $table->index('slug');
            }
            if (!$this->hasIndex('gallery_projects', 'gallery_projects_is_active_order_index')) {
                $table->index(['is_active', 'order']);
            }
        });

        // Clients table indexes
        Schema::table('clients', function (Blueprint $table) {
            if (!$this->hasIndex('clients', 'clients_is_active_order_index')) {
                $table->index(['is_active', 'order']);
            }
        });

        // Testimonials table indexes
        Schema::table('testimonials', function (Blueprint $table) {
            if (!$this->hasIndex('testimonials', 'testimonials_is_active_order_index')) {
                $table->index(['is_active', 'order']);
            }
        });

        // Hero slides table indexes
        Schema::table('hero_slides', function (Blueprint $table) {
            if (!$this->hasIndex('hero_slides', 'hero_slides_is_active_order_index')) {
                $table->index(['is_active', 'order']);
            }
        });

        // Settings table index on key (most queried column)
        Schema::table('settings', function (Blueprint $table) {
            if (!$this->hasIndex('settings', 'settings_key_index')) {
                $table->index('key');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['is_active', 'order']);
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['is_published', 'created_at']);
        });
        Schema::table('gallery_projects', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['is_active', 'order']);
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'order']);
        });
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'order']);
        });
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'order']);
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->dropIndex(['key']);
        });
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        try {
            $indexes = \Illuminate\Support\Facades\DB::select("SELECT name FROM sqlite_master WHERE type='index' AND tbl_name=? AND name=?", [$table, $indexName]);
            return count($indexes) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }
};
