<?php
// app/Http/Controllers/AdminDashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Dashboard para administradores
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Verificar que sea admin, si no redirigir a user dashboard
        if (!$user->isAdmin()) {
            return redirect()->route('user.dashboard');
        }
        
        // Estadísticas básicas para el admin
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'recent_users' => User::where('role', 'user')->latest()->take(5)->get(),
        ];
        
        return view('admin.dashboard', compact('user', 'stats'));
    }
}