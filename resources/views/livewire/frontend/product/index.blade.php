<div>
    <div class="row">
        <div class="col-md-3">
            {{-- part:23 --}}
            @if ($category->brands)


            <div class="card ">
                <div class="card-header text-white bg-primary"><h4>Brands</h4></div>
                <div class="card-body text-white bg-secondary">
                    @foreach ($category->brands as $brandItem)
                    <label class="d-block">
                        <input type="checkbox" wire:model="brandInputs" value="{{ $brandItem->name }}" /> {{ $brandItem->name }}
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="card mt-3 ">
                <div class="card-header text-white bg-primary"><h4>Price</h4></div>
                <div class="card-body text-white bg-secondary">
                    <label class="d-block">
                        <input type="radio" name="priceSort" wire:model="priceInput" value="high-to-low" />High Price
                    </label>
                    <label class="d-block">
                        <input type="radio" name="priceSort" wire:model="priceInput" value="low-to-high" />Low Price
                    </label>

                </div>
            </div>
        </div>
        <div class="col-md-9">

        <div class="row">
            @forelse ($products as $productItem)
            <div class="col-md-4">
                <div class="product-card">
                    <div class="product-card-img">
                        @if ($productItem->quantity >0)
                            <label class="stock bg-success">In Stock</label>
                        @else
                        <label class="stock bg-danger">Out Of Stock</label>

                        @endif
                        @if($productItem->productImages->count() > 0)
                        <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}">
                        <img src="{{ asset($productItem->productImages[0]->image) }}" alt="{{$productItem->name}}">
                        </a>
                        @endif
                    </div>
                    <div class="product-card-body">
                        <p class="product-brand">{{ $productItem->brand }}</p>
                        <h5 class="product-name">
                        <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}">
                                {{$productItem->name}}
                        </a>
                        </h5>
                        <div>
                            <span class="selling-price">{{ $productItem->selling_price}}</span>
                            <span class="original-price">{{ $productItem->original_price}}</span>
                        </div>

                    </div>
                </div>
            </div>

            @empty
            <div class="col-md-12">
                <div class="div p-2">
                    <h4>No Products Available{{ $category->name }}</h4>
                </div>
            </div>
            @endforelse
        </div>


    </div>
</div>
</div>
