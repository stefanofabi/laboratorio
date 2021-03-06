<?php

namespace App\Http\Controllers\Administrators\Prescribers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Pagination;

use App\Laboratory\Repositories\Prescribers\PrescriberRepositoryInterface;

use Lang;

class PrescriberController extends Controller
{
    use Pagination;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    /** @var \App\Laboratory\Repositories\Prescribers\PrescriberRepositoryInterface */
    private $prescriberRepository;

    public function __construct(PrescriberRepositoryInterface $prescriberRepository)
    {
        $this->prescriberRepository = $prescriberRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('administrators/prescribers/prescribers');
    }

    /**
     * Load prescribers
     *
     * @param \Illuminate\Http\Request $request
     * @return View $view
     */
    public function load(Request $request)
    {
        $request->validate([
            'filter' => 'string|nullable',
            'page' => 'required|numeric|min:1',
        ]);

        // Request
        $filter = $request->filter;
        $page = $request->page;

        $offset = ($page - 1) * self::PER_PAGE;
        $prescribers = $this->prescriberRepository->index($filter, $offset, self::PER_PAGE);

        // Pagination
        $count_rows = $prescribers->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);

        return view('administrators/prescribers/index')
            ->with('request', $request)
            ->with('prescribers', $prescribers)
            ->with('paginate', $paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('administrators/prescribers/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'email|nullable',
        ]);

        try {
            if (! $prescriber = $this->prescriberRepository->create($request->all())) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }
        
        return redirect()->action([PrescriberController::class, 'show'], ['id' => $prescriber->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $prescriber = $this->prescriberRepository->findOrFail($id);

        return view('administrators/prescribers/show')->with('prescriber', $prescriber);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $prescriber = $this->prescriberRepository->findOrFail($id);

        return view('administrators/prescribers/edit')->with('prescriber', $prescriber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        try {
            if (! $this->prescriberRepository->update($request->except(['_token', '_method']), $id)) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([PrescriberController::class, 'show'], ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        try {
            if (!$this->prescriberRepository->delete($id)) {
                return back()->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return back()->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return view('administrators/prescribers/prescribers')->with('success', [Lang::get('prescribers.success_destroy_message')]);
    }
}
