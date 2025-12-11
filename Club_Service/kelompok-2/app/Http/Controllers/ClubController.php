<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClubRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Club;

class ClubController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['apiIndex', 'apiStore', 'apiShow', 'apiUpdate', 'apiDestroy']);
    }

    // ============================================
    // WEB METHODS (untuk backend dashboard)
    // ============================================

    public function index()
    {
        $user = Auth::user();

        // semua user bisa lihat semua data club
        $clubs = Club::all();

        return view('backend.club.index', compact('clubs'));
    }

    public function create()
    {
        return view('backend.club.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateClub($request);
        $validated['user_id'] = Auth::id(); // simpan siapa yg input

        Club::create($validated);

        return redirect()->route('backend.club.index')->with('success', 'Club berhasil ditambahkan');
    }

    public function edit($id)
    {
        $club = Club::findOrFail($id);

        $this->authorizeClub($club);

        return view('backend.club.edit', compact('club'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $club = Club::findOrFail($id);

        $this->authorizeClub($club);

        $validated = $this->validateClub($request);

        $club->update($validated);

        return redirect()->route('backend.club.index')->with('success', 'Club berhasil diperbarui');
    }

    public function destroy($id): RedirectResponse
    {
        $club = Club::findOrFail($id);

        $this->authorizeClub($club);

        $club->delete();

        return redirect()->route('backend.club.index')->with('success', 'Club berhasil dihapus');
    }

    // ============================================
    // API METHODS (untuk Gateway)
    // ============================================

    /**
     * Display a listing of the clubs (API).
     * 
     * GET /api/v1/clubs
     */
    public function apiIndex(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 15);
            $clubs = Club::paginate($perPage);

            Log::info('Club list retrieved successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'total' => $clubs->total(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Daftar club berhasil diambil',
                'data' => $clubs->items(),
                'meta' => [
                    'current_page' => $clubs->currentPage(),
                    'last_page' => $clubs->lastPage(),
                    'per_page' => $clubs->perPage(),
                    'total' => $clubs->total(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve club list', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created club (API).
     * 
     * POST /api/v1/clubs
     */
    public function apiStore(ClubRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            
            // Set default user_id jika tidak ada (untuk API tanpa auth)
            if (!isset($validated['user_id'])) {
                $validated['user_id'] = $request->input('user_id', 1);
            }

            $club = Club::create($validated);

            Log::info('Club created successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $club->id,
                'club_name' => $club->nama,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Club berhasil ditambahkan',
                'data' => $club,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create club', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'error' => $e->getMessage(),
                'input' => $request->except(['password']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified club (API).
     * 
     * GET /api/v1/clubs/{id}
     */
    public function apiShow(Request $request, int $id): JsonResponse
    {
        try {
            $club = Club::find($id);

            if (!$club) {
                Log::warning('Club not found', [
                    'correlation_id' => $request->header('X-Correlation-ID'),
                    'club_id' => $id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Club tidak ditemukan',
                    'error' => 'Not Found',
                ], 404);
            }

            Log::info('Club detail retrieved successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $club->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Detail club berhasil diambil',
                'data' => $club,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve club detail', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified club (API).
     * 
     * PUT /api/v1/clubs/{id}
     */
    public function apiUpdate(ClubRequest $request, int $id): JsonResponse
    {
        try {
            $club = Club::find($id);

            if (!$club) {
                Log::warning('Club not found for update', [
                    'correlation_id' => $request->header('X-Correlation-ID'),
                    'club_id' => $id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Club tidak ditemukan',
                    'error' => 'Not Found',
                ], 404);
            }

            $validated = $request->validated();
            $club->update($validated);

            Log::info('Club updated successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $club->id,
                'club_name' => $club->nama,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Club berhasil diperbarui',
                'data' => $club->fresh(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update club', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified club (API).
     * 
     * DELETE /api/v1/clubs/{id}
     */
    public function apiDestroy(Request $request, int $id): JsonResponse
    {
        try {
            $club = Club::find($id);

            if (!$club) {
                Log::warning('Club not found for deletion', [
                    'correlation_id' => $request->header('X-Correlation-ID'),
                    'club_id' => $id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Club tidak ditemukan',
                    'error' => 'Not Found',
                ], 404);
            }

            $clubName = $club->nama;
            $club->delete();

            Log::info('Club deleted successfully', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $id,
                'club_name' => $clubName,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Club berhasil dihapus',
                'data' => null,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete club', [
                'correlation_id' => $request->header('X-Correlation-ID'),
                'club_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus club',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // ===== Helper Methods =====

    private function validateClub(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|min:2|max:255',
            'lokasi' => 'required|string|min:2|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);
    }

    private function authorizeClub(Club $club): void
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return;
        }

        if ($club->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
    }
}
