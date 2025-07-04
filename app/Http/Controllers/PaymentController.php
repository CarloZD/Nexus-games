<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditCard;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Game;
use App\Models\UserLibrary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Mostrar formulario de pago
     */
    public function showPaymentForm($gameId)
    {
        $game = Game::findOrFail($gameId);
        
        // Verificar que el usuario no tenga ya el juego
        if (Auth::user()->ownsGame($gameId)) {
            return redirect()->route('library.index')->with('error', 'Ya tienes este juego en tu biblioteca');
        }

        // Obtener tarjetas disponibles por banco
        $interbankCards = CreditCard::active()->byBank('Interbank')->get();
        $bcpCards = CreditCard::active()->byBank('BCP')->get();

        return view('payment.form', compact('game', 'interbankCards', 'bcpCards'));
    }

    /**
     * Procesar el pago
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'card_number' => 'required|string',
            'cardholder_name' => 'required|string|max:255',
            'expiry_date' => 'required|string|regex:/^(0[1-9]|1[0-2])\/\d{4}$/',
            'cvv' => 'required|string|min:3|max:4',
        ], [
            'card_number.required' => 'El número de tarjeta es obligatorio',
            'cardholder_name.required' => 'El nombre del titular es obligatorio',
            'expiry_date.required' => 'La fecha de expiración es obligatoria',
            'expiry_date.regex' => 'La fecha debe tener el formato MM/YYYY',
            'cvv.required' => 'El CVV es obligatorio',
        ]);

        try {
            DB::beginTransaction();

            $game = Game::findOrFail($request->game_id);
            $user = Auth::user();

            // Verificar nuevamente que no tenga el juego
            if ($user->ownsGame($request->game_id)) {
                throw new \Exception('Ya tienes este juego en tu biblioteca');
            }

            // Buscar la tarjeta que coincida con los datos ingresados
            $card = $this->findMatchingCard(
                $request->card_number,
                $request->expiry_date,
                $request->cvv,
                $request->cardholder_name
            );

            if (!$card) {
                throw new \Exception('Los datos de la tarjeta son incorrectos');
            }

            // Verificar que la tarjeta puede hacer el pago
            if (!$card->canMakePayment($game->price)) {
                throw new \Exception('Fondos insuficientes en la tarjeta');
            }

            // Procesar el pago
            $paymentResult = $card->processPayment($game->price, "Compra de {$game->title}");

            // Crear la orden
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $game->price,
                'status' => 'completed',
                'payment_method' => 'credit_card',
                'payment_status' => 'paid',
                'payment_details' => [
                    'card_type' => $card->card_type,
                    'bank_name' => $card->bank_name,
                    'last_four' => substr(str_replace(' ', '', $card->card_number), -4),
                    'transaction_id' => $paymentResult['transaction_id']
                ],
                'billing_details' => [
                    'cardholder_name' => $card->cardholder_name,
                    'billing_address' => 'Lima, Perú' // Simplificado
                ],
                'completed_at' => now(),
            ]);

            // Crear el item de la orden
            OrderItem::create([
                'order_id' => $order->id,
                'game_id' => $game->id,
                'game_title' => $game->title,
                'price' => $game->price,
                'quantity' => 1,
            ]);

            // Agregar el juego a la biblioteca del usuario
            UserLibrary::create([
                'user_id' => $user->id,
                'game_id' => $game->id,
                'purchased_at' => now(),
                'purchase_price' => $game->price,
                'hours_played' => 0,
                'status' => 'not_played',
                'is_favorite' => false,
            ]);

            DB::commit();

            return redirect()->route('payment.success', $order->id)->with('success', 'Compra realizada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['payment' => $e->getMessage()]);
        }
    }

    /**
     * Buscar tarjeta que coincida con los datos ingresados
     */
    private function findMatchingCard($cardNumber, $expiryDate, $cvv, $holderName)
    {
        $cards = CreditCard::active()->get();

        foreach ($cards as $card) {
            if ($card->validateCardData($cardNumber, $expiryDate, $cvv, $holderName)) {
                return $card;
            }
        }

        return null;
    }

    /**
     * Página de éxito
     */
    public function paymentSuccess($orderId)
    {
        $order = Order::with(['items.game', 'user'])
                     ->where('id', $orderId)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        return view('payment.success', compact('order'));
    }

    /**
     * API para obtener información de tarjetas por banco (para el frontend)
     */
    public function getCardsByBank($bank)
    {
        $cards = CreditCard::active()
                          ->byBank($bank)
                          ->get()
                          ->map(function ($card) {
                              return [
                                  'id' => $card->id,
                                  'masked_number' => $card->getMaskedCardNumber(),
                                  'card_type' => $card->card_type,
                                  'bank_name' => $card->bank_name,
                                  'available_credit' => $card->getFormattedAvailableCredit(),
                                  'icon' => $card->getCardIcon(),
                                  'color' => $card->card_color
                              ];
                          });

        return response()->json($cards);
    }

    /**
     * Verificar disponibilidad de fondos (AJAX)
     */
    public function checkCardFunds(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string',
            'amount' => 'required|numeric|min:0'
        ]);

        try {
            $card = CreditCard::active()
                             ->where('card_number', $request->card_number)
                             ->first();

            if (!$card) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tarjeta no encontrada'
                ]);
            }

            $canPay = $card->canMakePayment($request->amount);

            return response()->json([
                'success' => true,
                'can_pay' => $canPay,
                'available_credit' => $card->getFormattedAvailableCredit(),
                'message' => $canPay ? 'Fondos suficientes' : 'Fondos insuficientes'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar fondos'
            ]);
        }
    }
}