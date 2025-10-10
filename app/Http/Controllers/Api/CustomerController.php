<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateCustomerProfileRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers (Admin only)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Customer::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by verification status
        if ($request->has('verified')) {
            $query->where('phone_verified_at', $request->get('verified') ? '!=' : '=', null);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $customers = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'customers' => CustomerResource::collection($customers->items()),
                'pagination' => [
                    'current_page' => $customers->currentPage(),
                    'last_page' => $customers->lastPage(),
                    'per_page' => $customers->perPage(),
                    'total' => $customers->total(),
                ]
            ]
        ]);
    }

    /**
     * Display the specified customer
     */
    public function show($id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer)
        ]);
    }

    /**
     * Get current authenticated customer profile
     */
    public function profile(): JsonResponse
    {
        $customer = Auth::guard('api')->user();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer)
        ]);
    }

    /**
     * Update customer profile
     */
    public function updateProfile(UpdateCustomerProfileRequest $request): JsonResponse
    {
        $customer = Auth::guard('api')->user();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        $customer->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate',
            'data' => new CustomerResource($customer->fresh())
        ]);
    }

    /**
     * Update customer by admin
     */
    public function update(UpdateCustomerRequest $request, $id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        $customer->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil diupdate',
            'data' => new CustomerResource($customer->fresh())
        ]);
    }

    /**
     * Soft delete customer (Admin only)
     */
    public function destroy($id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dihapus'
        ]);
    }

    /**
     * Restore soft deleted customer (Admin only)
     */
    public function restore($id): JsonResponse
    {
        $customer = Customer::withTrashed()->find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        if (!$customer->trashed()) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak dalam status terhapus'
            ], 400);
        }

        $customer->restore();

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dipulihkan',
            'data' => new CustomerResource($customer)
        ]);
    }

    /**
     * Toggle customer active status (Admin only)
     */
    public function toggleStatus($id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        $customer->is_active = !$customer->is_active;
        $customer->save();

        $status = $customer->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json([
            'success' => true,
            'message' => "Customer berhasil {$status}",
            'data' => new CustomerResource($customer)
        ]);
    }

    /**
     * Get customer statistics (Admin only)
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_customers' => Customer::count(),
            'verified_customers' => Customer::whereNotNull('phone_verified_at')->count(),
            'unverified_customers' => Customer::whereNull('phone_verified_at')->count(),
            'active_customers' => Customer::where('is_active', true)->count(),
            'inactive_customers' => Customer::where('is_active', false)->count(),
            'deleted_customers' => Customer::onlyTrashed()->count(),
            'recent_registrations' => Customer::where('created_at', '>=', now()->subDays(7))->count()
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}