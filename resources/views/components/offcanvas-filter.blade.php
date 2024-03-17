<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <x-header class="offcanvas-title" id="offcanvasExampleLabel">Filter</x-header>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('movie.filter') }}" method="get" class="d-flex flex-column justify-content-between h-100 w-100">
            <div class="helper">
                <div class="helper--year my-2">
                    <h5 class="text-center m-0 py-2 bg-light-subtle rounded-3 mb-2">Year:</h5>
                    <div class="w-100 d-flex justify-content-between">
                        <input class="w-25" type="number" name="min_year" placeholder="From" min="1895" max="{{ now()->year }}" step="1">
                        <input class="w-25" type="number" name="max_year" placeholder="To" min="1895" max="{{ now()->year }}" step="1">
                    </div>
                </div>
                <div class="helper--genre my-2">
                    <h5 class="text-center m-0 py-2 bg-light-subtle rounded-3">Genre:</h5>
                    <div class="form-check-inline p-0 mt-2" >
                        @foreach($genres as $genre)
                        <input type="checkbox" class="btn-check mb-1" name="genres[]" value="{{ $genre->id }}" id="{{ $genre->id }}" autocomplete="off">
                        <label class="btn mb-1" for="{{ $genre->id }}">{{ ucfirst($genre->name) }}</label>
                        @endforeach
                    </div>
                </div>
                <div class="helper--rating my-2">
                    <h5 class="text-center m-0 py-2 bg-light-subtle rounded-3 mb-2">Cinema-online rating:</h5>
                    <div class="w-100 d-flex justify-content-between">
                        <input class="w-25" type="number" name="min_rating" placeholder="From" min="0" max="5" step="1">
                        <input class="w-25" type="number" name="max_rating" placeholder="To" min="0" max="5" step="1">
                    </div>
                </div>
                <div class="helper--country my-2">
                    <h5 class="text-center m-0 py-2 bg-light-subtle rounded-3 mb-2">Country</h5>
                    @foreach($filterData['countries'] as $country)
                    <input type="checkbox" class="btn-check mb-1" name="country[]" value="{{ $country }}" id="{{ $country }}" autocomplete="off">
                    <label class="btn mb-1" for="{{ $country }}">{{ $country }}</label>
                    @endforeach
                </div>
                <div class="helper--production-studio my-2">
                    <h5 class="text-center m-0 py-2 bg-light-subtle rounded-3 mb-2">Production studio</h5>
                    @foreach($filterData['productionStudios'] as $productionStudio)
                    <input type="checkbox" class="btn-check mb-1" name="production_studio[]" value="{{ $productionStudio }}" id="{{ $productionStudio }}" autocomplete="off">
                    <label class="btn mb-1" for="{{ $productionStudio }}">{{ $productionStudio }}</label>
                    @endforeach
                </div>
            </div>
            <button class="btn btn-outline-light" type="submit">Accept</button>
        </form>
    </div>
</div>
