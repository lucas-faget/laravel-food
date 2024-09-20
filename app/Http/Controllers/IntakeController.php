<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Intakes",
 *     description="Intakes"
 * )
 */
class IntakeController extends Controller
{
    protected function validateIntake(Request $request)
    {
        return $request->validate([
            'amount' => 'numeric',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/intakes",
     *     tags={"Intakes"},
     *     summary="Get all intakes",
     *     description="Get all intakes",
     *     @OA\Response(
     *         response=200,
     *         description="All intakes"
     *     )
     * )
     */
    public function index()
    {
        $intakes = Intake::all();

        return response()->json($intakes);
    }

    /**
     * @OA\Get(
     *     path="/intakes/{id}",
     *     tags={"Intakes"},
     *     summary="Get an intake by ID",
     *     description="Get an intake by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Intake ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Intake"
     *     )
     * )
     */
    public function show(Intake $intake)
    {
        return response()->json($intake);
    }

    /**
     * @OA\Post(
     *     path="/intakes",
     *     tags={"Intakes"},
     *     summary="Create an intake",
     *     description="Create an intake",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="product_id", type="integer"),
     *             @OA\Property(property="amount", type="number", format="float", default=0),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Intake created successfully",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'amount' => 'required',
        ]);

        $this->validateIntake($request);

        $intake = Intake::create($request->all());

        return response()->json($intake, 201);
    }

    /**
     * @OA\Put(
     *     path="/intakes/{id}",
     *     tags={"Intakes"},
     *     summary="Update an intake",
     *     description="Update an intake",
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
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="product_id", type="integer"),
     *             @OA\Property(property="amount", type="number", format="float", default=0),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Intake updated successfully",
     *     )
     * )
     */
    public function update(Request $request, Intake $intake)
    {
        $this->validateIntake($request);

        $intake->update($request->all());

        return response()->json($intake, 200);
    }

    /**
     * @OA\Delete(
     *     path="/intakes/{id}",
     *     tags={"Intakes"},
     *     summary="Delete an intake",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Intake ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Intake deleted successfully"
     *     )
     * )
     */
    public function destroy(Intake $intake)
    {
        $intake->delete();

        return response()->json(null, 204);
    }
}
