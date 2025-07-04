<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Mostrar el carrito del usuario
     */
    public function index()
    {
        $user = Auth::user();
        $cart = $user->getActiveCart();
        
        // Obtener items del carrito con información del juego
        $cartItems = $cart->items()->with(['game.category'])->get();
        
        // Calcular totales
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        $total = $subtotal; // Por ahora sin impuestos adicionales
        
        return view('cart.index', compact('cartItems', 'subtotal', 'total'));
    }

    /**
     * Agregar juego al carrito
     */
    public function add(Request $request, Game $game)
    {
        try {
            $user = Auth::user();
            
            // Verificar que el juego esté activo
            if (!$game->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este juego no está disponible'
                ]);
            }
            
            // Verificar que el usuario no tenga ya el juego en su biblioteca
            if ($user->ownsGame($game->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya tienes este juego en tu biblioteca'
                ]);
            }
            
            // Obtener o crear carrito activo
            $cart = $user->getActiveCart();
            
            // Verificar si el juego ya está en el carrito
            $existingItem = $cart->items()->where('game_id', $game->id)->first();
            
            if ($existingItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este juego ya está en tu carrito'
                ]);
            }
            
            // Agregar el juego al carrito
            $cartItem = $cart->addGame($game);
            
            // Obtener el nuevo contador del carrito
            $cartCount = $cart->getTotalItems();
            
            return response()->json([
                'success' => true,
                'message' => "'{$game->title}' agregado al carrito",
                'cart_count' => $cartCount,
                'item_id' => $cartItem->id
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar el juego al carrito: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Eliminar item del carrito
     */
    public function remove(CartItem $item)
    {
        try {
            $user = Auth::user();
            
            // Verificar que el item pertenezca al usuario
            if ($item->cart->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permiso para eliminar este item'
                ]);
            }
            
            $gameTitle = $item->game->title;
            $item->delete();
            
            // Obtener el nuevo contador del carrito
            $cart = $user->getActiveCart();
            $cartCount = $cart->getTotalItems();
            
            return response()->json([
                'success' => true,
                'message' => "'{$gameTitle}' eliminado del carrito",
                'cart_count' => $cartCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el juego del carrito'
            ]);
        }
    }

    /**
     * Limpiar todo el carrito
     */
    public function clear()
    {
        try {
            $user = Auth::user();
            $cart = $user->getActiveCart();
            
            $itemCount = $cart->getTotalItems();
            $cart->clearCart();
            
            return response()->json([
                'success' => true,
                'message' => "Se eliminaron {$itemCount} juegos del carrito",
                'cart_count' => 0
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al limpiar el carrito'
            ]);
        }
    }

    /**
     * Obtener contador del carrito (AJAX)
     */
    public function getCount()
    {
        try {
            $user = Auth::user();
            $cart = $user->getActiveCart();
            $cartCount = $cart->getTotalItems();
            
            return response()->json([
                'success' => true,
                'cart_count' => $cartCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'cart_count' => 0
            ]);
        }
    }

    /**
     * Actualizar cantidad de un item (para futuro uso)
     */
    public function updateQuantity(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);
        
        try {
            $user = Auth::user();
            
            // Verificar que el item pertenezca al usuario
            if ($item->cart->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permiso para modificar este item'
                ]);
            }
            
            $item->update(['quantity' => $request->quantity]);
            
            // Calcular nuevo subtotal del item
            $subtotal = $item->price * $item->quantity;
            
            // Obtener nuevo total del carrito
            $cart = $user->getActiveCart();
            $cartTotal = $cart->getTotalPrice();
            
            return response()->json([
                'success' => true,
                'message' => 'Cantidad actualizada',
                'item_subtotal' => number_format($subtotal, 2),
                'cart_total' => number_format($cartTotal, 2)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la cantidad'
            ]);
        }
    }

    /**
     * Proceder al checkout (redirigir a pago)
     */
    public function checkout()
    {
        try {
            $user = Auth::user();
            $cart = $user->getActiveCart();
            $cartItems = $cart->items()->with('game')->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
            }
            
            // Por ahora, redirigir al pago del primer juego
            // En el futuro se puede implementar pago múltiple
            $firstGame = $cartItems->first()->game;
            
            return redirect()->route('payment.form', $firstGame->id)
                           ->with('info', 'Procesando pago individual. El carrito múltiple estará disponible pronto.');
            
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Error al proceder al checkout');
        }
    }

    /**
     * Verificar si un juego está en el carrito (AJAX)
     */
    public function isInCart(Game $game)
    {
        try {
            $user = Auth::user();
            $cart = $user->getActiveCart();
            
            $isInCart = $cart->items()->where('game_id', $game->id)->exists();
            
            return response()->json([
                'success' => true,
                'is_in_cart' => $isInCart
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'is_in_cart' => false
            ]);
        }
    }

    /**
     * Obtener resumen del carrito (AJAX)
     */
    public function getSummary()
    {
        try {
            $user = Auth::user();
            $cart = $user->getActiveCart();
            $cartItems = $cart->items()->with(['game.category'])->get();
            
            $summary = [
                'items_count' => $cartItems->count(),
                'total_quantity' => $cartItems->sum('quantity'),
                'subtotal' => $cart->getTotalPrice(),
                'total' => $cart->getTotalPrice(),
                'items' => $cartItems->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'game_title' => $item->game->title,
                        'game_image' => asset($item->game->image_url),
                        'price' => number_format($item->price, 2),
                        'quantity' => $item->quantity,
                        'subtotal' => number_format($item->price * $item->quantity, 2)
                    ];
                })
            ];
            
            return response()->json([
                'success' => true,
                'summary' => $summary
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener resumen del carrito'
            ]);
        }
    }
}