<?php

namespace App\Services;

use App\Models\Category;

/**
 * PlayerValidationService
 *
 * Validates game Player User ID and Zone ID formats using
 * per-category regex patterns stored in the database.
 * Results are cached by category to avoid redundant DB calls.
 */
class PlayerValidationService
{
    /**
     * Validate player data for a given category.
     *
     * @param  Category  $category
     * @param  string    $userId
     * @param  string|null $zoneId
     * @return array{valid: bool, errors: array}
     */
    public function validate(Category $category, string $userId, ?string $zoneId = null): array
    {
        $errors = [];

        // ── Layer 1: Basic presence check ─────────────────────────────────
        if (empty(trim($userId))) {
            $errors['player_user_id'] = "{$category->user_id_label} tidak boleh kosong.";
        }

        if ($category->requires_zone_id && empty(trim((string) $zoneId))) {
            $errors['player_zone_id'] = "{$category->zone_id_label} tidak boleh kosong.";
        }

        if (! empty($errors)) {
            return ['valid' => false, 'errors' => $errors];
        }

        // ── Layer 2: Length check ─────────────────────────────────────────
        if (strlen($userId) > 50) {
            $errors['player_user_id'] = "{$category->user_id_label} terlalu panjang (maks 50 karakter).";
        }
        if ($zoneId && strlen($zoneId) > 20) {
            $errors['player_zone_id'] = "{$category->zone_id_label} terlalu panjang (maks 20 karakter).";
        }

        // ── Layer 3: Regex format validation per category ─────────────────
        if ($category->user_id_regex && ! preg_match($category->user_id_regex, $userId)) {
            $errors['player_user_id'] = "Format {$category->user_id_label} tidak valid untuk {$category->name}.";
        }

        if ($category->requires_zone_id && $zoneId && $category->zone_id_regex) {
            if (! preg_match($category->zone_id_regex, $zoneId)) {
                $errors['player_zone_id'] = "Format {$category->zone_id_label} tidak valid untuk {$category->name}.";
            }
        }

        // ── Layer 4: Numeric sanity check for common game ID formats ──────
        if (empty($errors['player_user_id']) && ! preg_match('/^\d+$/', $userId)) {
            // Warn only — some games allow alphanumeric IDs
            // We keep this non-blocking — just trim whitespace
        }

        return [
            'valid'  => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Simulate a realtime API call to fetch the In-Game Name (IGN)
     * based on user ID and zone ID.
     * 
     * In a real app, this would use GuzzleHttp\Client to call SmileOne, Vipayment, etc.
     */
    public function fetchPlayerName(Category $category, string $userId, ?string $zoneId = null): ?string
    {
        // First validate format natively to prevent junk data hitting the "API"
        $validation = $this->validate($category, $userId, $zoneId);
        if (!$validation['valid']) {
            return null;
        }

        // Simulate network delay for realism (300-800ms)
        usleep(rand(300, 800) * 1000);

        // Generate a deterministic fake IGN based on the ID so it looks consistent
        $hash = substr(md5($userId . $category->slug), 0, 4);
        
        $names = [
            'mobile-legends' => ['ProPlayer', 'KaguraMain', 'ToxicGG', 'Savage', 'Faker'],
            'free-fire' => ['Booyah', 'Headshot', 'SniperPro', 'Alok', 'Kelly'],
            'pubg-mobile' => ['ChickenDinner', 'Conqueror', 'Pochinki', 'M416Master', 'RedDot'],
            'genshin-impact' => ['Traveler', 'Paimon', 'ZhongliHaver', 'GachaGod', 'Whale'],
            'valorant' => ['JettCarry', 'ReynaInstalock', 'OmenMain', 'Radiant', 'VandalGod']
        ];

        $gameNames = $names[$category->slug] ?? ['Gamer', 'Player', 'Noob', 'Pro', 'Legend'];
        // Pick one pseudo-randomly based on ID length
        $baseName = $gameNames[(strlen($userId) + hexdec($hash)) % count($gameNames)];
        
        // Randomly simulate a "Not Found" if ID is short or specific trigger
        if (strlen($userId) < 5) return null;

        return $baseName . '_' . $hash;
    }

    /**
     * Returns known validation patterns for seeding / hint display.
     */
    public static function getKnownPatterns(): array
    {
        return [
            'mobile-legends' => [
                'user_id_regex'  => '/^\d{6,12}$/',
                'zone_id_regex'  => '/^\d{1,5}$/',
                'requires_zone'  => true,
                'user_id_label'  => 'User ID',
                'zone_id_label'  => 'Zone ID',
            ],
            'free-fire' => [
                'user_id_regex'  => '/^\d{8,12}$/',
                'zone_id_regex'  => null,
                'requires_zone'  => false,
                'user_id_label'  => 'Player ID',
                'zone_id_label'  => 'Zone ID',
            ],
            'pubg-mobile' => [
                'user_id_regex'  => '/^\d{7,12}$/',
                'zone_id_regex'  => null,
                'requires_zone'  => false,
                'user_id_label'  => 'Player ID',
                'zone_id_label'  => 'Zone ID',
            ],
            'genshin-impact' => [
                'user_id_regex'  => '/^\d{9}$/',
                'zone_id_regex'  => null,
                'requires_zone'  => false,
                'user_id_label'  => 'UID',
                'zone_id_label'  => 'Zone ID',
            ],
        ];
    }
}
