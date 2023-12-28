<?php

namespace App\Repositories;

use App\Http\Requests\AdvertiseRequest;
use App\Http\Requests\AdvertiseUpdateRequest;
use App\Http\Requests\TableRequest;
use App\Models\Advertise;
use App\Repositories\Contracts\IAdvertiseRepository;
use App\Repositories\traits\GlobalFunc;
use App\Services\File\FileService;
use App\Services\Image\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class AdvertiseRepository implements IAdvertiseRepository {

    use GlobalFunc;

    /**
     * Get the places.
     * @return array
     */
    public function getPlaces() : array {

        return [
            [
                'id' => 1 , 'title'  => __('site.Top main page')
            ],
            [
                'id' => 2 , 'title'  => __('site.Left main page')
            ],
            [
                'id' => 3 , 'title'  => __('site.Top ranking main page'),
            ],
            [
                'id' => 4 , 'title'  =>__('site.Top archive page'),
            ],
            [
                'id' => 5 , 'title'  => __('site.Right archive page'),
            ],
            [
                'id' => 6 , 'title'  => __('site.Top single page'),
            ],
            [
                'id' => 7 , 'title'  => __('site.Right single page'),
            ],
            [
                'id' => 8 , 'title'  => __('site.Top static page'),
            ],
            [
                'id' => 9 , 'title'  => __('site.Top static page'),
            ],
            [
                'id' => 10 , 'title'  => __('site.Right static page'),
            ]
        ];
    }

    /**
     * Get the places.
     * @param array %places
     * @return array
     */
    public function index(array $places) : array {

        // ->addMinutes('1'),
        $advertise = cache()->remember("advertise.all", now(), function () use($places) {
            return Advertise::query()
                ->where('status', 1)
                ->whereIn('place_id',$places)
                ->get();
        });

        $result = [];

        foreach($advertise ?? [] as $key => $item) {
            $result[$item->place_id][$key]['id']         = $item->id;
            $result[$item->place_id][$key]['place_id']   = $item->place_id;
            $result[$item->place_id][$key]['title']      = $item->title;
            $result[$item->place_id][$key]['link']       = $item->link;
            $result[$item->place_id][$key]['status']     = $item->status;
            $result[$item->place_id][$key]['image']      = !empty($item->image) ? asset($item->image) : asset('/assets/site/images/user-icon.png');
        }

        return $result;
    }

    /**
     * Get the advertise pagination.
     * @param TableRequest $request
     * @return LengthAwarePaginator
     */
    public function indexPaginate(TableRequest $request) :LengthAwarePaginator
    {
        $search = $request->get('query');
        return Advertise::query()
            ->when(Auth::user()->level != 3, function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy($request->get('sortBy', 'id'), $request->get('sortType', 'desc'))
            ->paginate($request->get('rowsPerPage', 25));
    }

    /**
     * Get the advertise info.
     * @param Advertise $advertise
     * @return Matches
     */
    public function show(Advertise $advertise) :Advertise
    {
        return $advertise;
    }

    /**
     * Store the Advertise.
     * @param AdvertiseRequest $request
     * @return JsonResponse
     */
    public function store(AdvertiseRequest $request) :JsonResponse
    {
        $this->checkLevelAccess();

        $advertise = Advertise::create([
            'title'         => $request->input('title'),
            'image'         => $request->input('image'),
            'place_id'      => $request->input('place_id'),
            'link'          => $request->input('link'),
            'user_id'       => Auth::user()->id,
            'status'        => $request->input('status'),
        ]);

        if ($advertise) {
            return response()->json([
                'status' => 1,
                'message' => __('site.The operation has been successfully')
            ], Response::HTTP_CREATED);
        }

        throw new \Exception();

    }

    /**
     * Update the advertise.
     * @param AdvertiseRequest $request
     * @param Advertise $advertise
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(AdvertiseUpdateRequest $request, Advertise $advertise) :JsonResponse
    {
        $this->checkLevelAccess(Auth::user()->id == $advertise->user_id);

        $advertise->update([
            'title'         => $request->input('title'),
            'image'         => $request->input('image'),
            'place_id'      => $request->input('place_id'),
            'user_id'       => auth()->user()->id,
            'status'        => $request->input('status'),
            'link'          => $request->input('link'),
        ]);

        if ($advertise) {
            return response()->json([
                'status' => 1,
                'message' => __('site.The operation has been successfully')
            ], Response::HTTP_OK);
        }

        throw new \Exception();

    }

    /**
    * Delete the advertise.
    * @param Advertise $advertise
    * @return JsonResponse
    */
   public function destroy(Advertise $advertise) :JsonResponse
   {
        $this->checkLevelAccess(Auth::user()->id == $advertise->user_id);

        $advertise->delete();

        if ($advertise) {
            return response()->json([
                'status' => 1,
                'message' => __('site.The operation has been successfully')
            ], Response::HTTP_OK);
        }

        throw new \Exception();
   }
}
