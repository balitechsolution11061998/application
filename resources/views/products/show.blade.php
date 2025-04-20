<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Paguyuban Prices</h5>
    </div>
    <div class="card-body">
        @if($product->paguyubans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Paguyuban</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->paguyubans as $paguyuban)
                            <tr>
                                <td>{{ $paguyuban->name }}</td>
                                <td>Rp {{ number_format($paguyuban->pivot->price, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="mb-0">No special prices set for any paguyuban.</p>
        @endif
    </div>
</div>