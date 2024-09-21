<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Intakes",
 *     description="Intakes",
 * )
 */
class IntakeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/intakes",
     *     tags={"Intakes"},
     *     summary="Get all intakes",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="All intakes",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     */
    public function index()
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $intakes = $user->intakes;

        return response()->json($intakes);
    }

    /**
     * @OA\Get(
     *     path="/intakes/{id}",
     *     tags={"Intakes"},
     *     summary="Get an intake by ID",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Intake ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Intake",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Intake not found",
     *     ),
     * )
     */
    public function show(Intake $intake)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($intake->user_id !== $user->id) {
            return response()->json(['message' => 'Intake not found'], 404);
        }

        return response()->json($intake);
    }

    /**
     * @OA\Post(
     *     path="/intakes",
     *     tags={"Intakes"},
     *     summary="Create an intake",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="product_id", type="integer"),
     *             @OA\Property(property="amount", type="number", format="float", default=0),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Intake created successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $validatedIntake = $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $product = $user->products()->where('id', $request->product_id)->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $intake = $user->intakes()->create($validatedIntake);

        return response()->json($intake, 201);
    }

    /**
     * @OA\Put(
     *     path="/intakes/{id}",
     *     tags={"Intakes"},
     *     summary="Update an intake",
     *     description="Update an intake",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Intake ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="amount", type="number", format="float", default=0),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Intake updated successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Intake not found",
     *     ),
     * )
     */
    public function update(Request $request, Intake $intake)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validatedIntake = $request->validate([
            'amount' => 'numeric|min:0',
        ]);

        $intake->update($validatedIntake);

        return response()->json($intake, 200);
    }

    /**
     * @OA\Delete(
     *     path="/intakes/{id}",
     *     tags={"Intakes"},
     *     summary="Delete an intake",
     *     description="Delete an intake",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Intake ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Intake deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Intake not found",
     *     ),
     * )
     */
    public function destroy(Intake $intake)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($intake->user_id !== $user->id) {
            return response()->json(['message' => 'Intake not found'], 404);
        }

        $intake->delete();

        return response()->json(null, 204);
    }
}
