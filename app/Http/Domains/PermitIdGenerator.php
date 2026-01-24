<?php

namespace App\Http\Domains;

use App\Models\CuttingPermit;
use Exception;
use Illuminate\Support\Facades\DB;

class PermitIdGenerator
{
    /**
     * Generate a unique permit ID for cutting permits
     *
     * @param string $prefix Prefix for the permit ID (e.g., 'CP' for cutting permit)
     * @param int|null $year The year to include in the ID (defaults to current year)
     * @param int $length Length of the random/sequential part of the ID
     * @param string $delimiter Character(s) to separate parts of the ID
     * @param bool $useSequential Use a sequential number instead of random
     * @return string The generated unique permit ID
     * @throws Exception If a unique ID cannot be generated after multiple attempts
     */
    public function generate(
        string $prefix = 'CP',
        ?int $year = null,
        int $length = 6,
        string $delimiter = '-',
        bool $useSequential = false
    ): string {
        // Use current year if not specified
        $year = $year ?? date('Y');
        
        // Maximum attempts to find a unique ID to prevent infinite loops
        $maxAttempts = 100;
        $attempts = 0;
        
        do {
            if ($useSequential) {
                // Get the highest existing permit number for this prefix and year
                $lastPermitId = $this->getLastSequentialId($prefix, $year, $delimiter);
                
                if ($lastPermitId) {
                    // Extract the number part and increment
                    $parts = explode($delimiter, $lastPermitId);
                    $lastNumber = intval(end($parts));
                    $number = $lastNumber + 1;
                } else {
                    // Start from 1 if no permits exist
                    $number = 1;
                }
                
                // Format the number with leading zeros
                $randomPart = str_pad($number, $length, '0', STR_PAD_LEFT);
            } else {
                // Generate a random alphanumeric string
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomPart = '';
                
                for ($i = 0; $i < $length; $i++) {
                    $randomPart .= $characters[random_int(0, strlen($characters) - 1)];
                }
            }
            
            // Construct the permit ID
            $permitId = $prefix . $delimiter . $year . $delimiter . $randomPart;
            
            // Check if the ID already exists in the database
            $exists = $this->permitIdExists($permitId);
            
            $attempts++;
        } while ($exists && $attempts < $maxAttempts);
        
        // If we exceeded max attempts, throw an exception
        if ($exists) {
            throw new Exception("Could not generate a unique permit ID after {$maxAttempts} attempts.");
        }
        
        return $permitId;
    }
    
    /**
     * Check if a permit ID already exists in the database
     *
     * @param string $permitId The permit ID to check
     * @return bool Whether the permit ID exists
     */
    protected function permitIdExists(string $permitId): bool
    {
        return CuttingPermit::where('permit_id', $permitId)->exists();
    }
    
    /**
     * Get the last sequential permit ID for a given prefix and year
     *
     * @param string $prefix The permit prefix
     * @param int $year The permit year
     * @param string $delimiter The delimiter used in the permit ID
     * @return string|null The last permit ID or null if none exists
     */
    protected function getLastSequentialId(string $prefix, int $year, string $delimiter): ?string
    {
        // Use Laravel's query builder to find the highest sequential ID
        return CuttingPermit::where('permit_id', 'LIKE', "{$prefix}{$delimiter}{$year}{$delimiter}%")
            ->orderByRaw("CAST(SUBSTRING_INDEX(permit_id, '{$delimiter}', -1) AS UNSIGNED) DESC")
            ->value('permit_id');
    }
}