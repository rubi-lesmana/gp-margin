<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    /**
     * Validasi overlap range quantity dengan data existing.
     */
    public function checkOverlap(int $minQuantity, ?int $maxQuantity, ?string $excludeStatus = null): void
    {
        $overlap = Category::where(function ($query) use ($minQuantity, $maxQuantity) {
                if (is_null($maxQuantity)) {
                    $query->where('min_quantity', '>=', $minQuantity)
                        ->orWhere(function ($q) use ($minQuantity) {
                            $q->where('min_quantity', '<=', $minQuantity)
                                ->where(function ($q2) use ($minQuantity) {
                                    $q2->whereNull('max_quantity')
                                        ->orWhere('max_quantity', '>=', $minQuantity);
                                });
                        });
                } else {
                    $query->where('min_quantity', '<=', $maxQuantity)
                        ->where(function ($q) use ($minQuantity) {
                            $q->whereNull('max_quantity')
                                ->orWhere('max_quantity', '>=', $minQuantity);
                        });
                }
            })
            ->when($excludeStatus, fn($q) => $q->where('status', '!=', $excludeStatus))
            ->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'min_quantity' => 'Range quantity yang diinput overlap dengan data yang sudah ada.',
            ]);
        }
    }

    /**
     * Validasi status unik (primary key string).
     */
    public function checkStatusUnique(string $status, ?string $excludeStatus = null): void
    {
        $exists = Category::where('status', $status)
            ->when($excludeStatus, fn($q) => $q->where('status', '!=', $excludeStatus))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'status' => 'Status sudah digunakan.',
            ]);
        }
    }

    /**
     * Simpan data baru.
     */
    public function store(array $data): Category
    {
        $this->checkStatusUnique($data['status']);
        $this->checkOverlap($data['min_quantity'], $data['max_quantity'] ?? null);

        return Category::create($data);
    }

    /**
     * Update data existing.
     */
    public function update(Category $category, array $data): Category
    {
        $this->checkStatusUnique($data['status'], $category->status);
        $this->checkOverlap($data['min_quantity'], $data['max_quantity'] ?? null, $category->status);

        $category->update($data);

        return $category->fresh();
    }

    /**
     * Hapus data.
     */
    public function destroy(Category $category): void
    {
        $category->delete();
    }
}