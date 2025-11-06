<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Menampilkan daftar semua user dengan filter
     */
    public function index(Request $request)
    {
        $query = User::with('role');
        
        // Filter berdasarkan role
        if ($request->has('role') && $request->role != '') {
            $query->where('role_id', $request->role);
        }
        
        // Filter berdasarkan status (aktif/nonaktif)
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status);
        }
        
        // Pencarian nama atau email
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->latest()->paginate(15);
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }
    
    /**
     * Menampilkan form tambah user baru
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }
    
    /**
     * Menyimpan user baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'is_member' => 'boolean'
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;
        
        User::create($validated);
        
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }
    
    /**
     * Menampilkan detail user dan riwayat transaksinya
     */
    public function show(User $user)
    {
        $user->load(['role', 'sales' => function($query) {
            $query->with('items.variant.product')->latest();
        }, 'orders' => function($query) {
            $query->with('items.variant.product')->latest();
        }]);
        
        // Hitung total pembelian user dari sales (POS) dan orders (Online)
        $totalSpent = $user->sales->sum('total') + $user->orders->sum('total');
        $totalTransactions = $user->sales->count() + $user->orders->count();
        
        return view('admin.users.show', compact('user', 'totalSpent', 'totalTransactions'));
    }
    
    /**
     * Menampilkan form edit user
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }
    
    /**
     * Update data user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'is_member' => 'boolean',
            'is_active' => 'boolean'
        ]);
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed'
            ]);
            $validated['password'] = Hash::make($request->password);
        }
        
        $user->update($validated);
        
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }
    
    /**
     * Mengaktifkan atau menonaktifkan user
     */
    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);
        
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "User berhasil {$status}!");
    }
    
    /**
     * Hapus user (soft delete jika ada)
     */
    public function destroy(User $user)
    {
        // Cegah menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }
        
        $user->delete();
        
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
