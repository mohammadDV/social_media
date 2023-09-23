<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StepRequest;
use App\Http\Requests\StepUpdateRequest;
use App\Http\Requests\StoreClubRequest;
use App\Http\Requests\TableRequest;
use App\Models\League;
use App\Models\Step;
use App\Repositories\Contracts\IStepRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StepController extends Controller
{
    /**
     * Constructor of StepController.
     */
    public function __construct(protected  IStepRepository $repository)
    {
        //
    }

    /**
     * Get the step.
     * @param Step $step
     * @return JsonResponse
     */
    public function getStepInfo(Step $step) :JsonResponse
    {
        return response()->json($this->repository->getStepInfo($step), Response::HTTP_OK);
    }

    /**
     * Store the step.
     * @param StepRequest $request
     * @param League $league
     * @return JsonResponse
     */
    public function store(StepRequest $request, League $league) :JsonResponse
    {
        return $this->repository->store($request, $league);
    }

    /**
     * Update the step.
     * @param StepRequest $request
     * @param Step $step
     * @return JsonResponse
     */
    public function update(StepRequest $request, Step $step) :JsonResponse
    {
        return $this->repository->update($request, $step);
    }

    /**
     * Delete the step.
     * @param Step $step
     * @return JsonResponse
     */
    public function destroy(Step $step) :JsonResponse
    {
        return $this->repository->destroy($step);
    }

    /**
     * Store the club to the step.
     * @param Step $step
     * @return JsonResponse
     */
    public function storeClubs(StoreClubRequest $request, Step $step) :JsonResponse
    {
        return $this->repository->storeClubs($request, $step);
    }

     /**
    * Get the clubs of step.
    * @param Step $step
    * @return JsonResponse
    */
    public function getClubs(Step $step) :JsonResponse
    {
        return response()->json($this->repository->getClubs($step), Response::HTTP_OK);
    }
}