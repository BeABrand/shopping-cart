@extends('layouts.app')

@section('content')

<div class="ui container stackable grid">

	<div class="eleven wide column">

	@if($basket->itemCount())
		
		<div class="ui segment">

			<table class="ui very basic table">

				<thead>
					<tr>
						<th>Product</th>
						<th>Price</th>
						<th>Quantity</th>
					</tr>
				</thead>

				<tbody>
				@foreach($basket->all() as $item)
					<tr>
						<td>
							<a href="{{ route('product.view', $item->slug) }}">{{ $item->title }}</a>
						</td>
						<td>€{{ number_format($item->price, 2, ',', ' ') }}</td>
						<td>
							<form action="{{ route('cart.update', $item->slug) }}" method="POST">
								{{ csrf_field() }}
								<div class="ui action input">
									<select class="ui compact selection dropdown" name="quantity">
									@for($num = 1; $num <= $item->stock; $num++)
										<option value="{{ $num }}" {{ ($num == $item->quantity) ? 'selected' : '' }}>{{ $num }}</option>
									@endfor
								    	<option value="0">None</option>
								  	</select>

								  	<button class="ui button" type="submit">Update</button>
								</div>
							</form>
						</td>
					</tr>
				@endforeach
				</tbody>

			</table>

		</div>

	@else
		<p>You have no items in your cart. <a href="{{ route('home') }}">Start shopping</a></p>
	@endif
	</div>

	<div class="five wide column">
		<div class="ui segments">
			<div class="ui segment">
				<h4>Cart summary</h4>
			</div>

		@if($basket->itemCount() and $basket->subTotal())
			
			<div class="ui segment">
				@include('pages.cart.partials.summary')
			</div>

			<div class="ui segment">
				<a class="ui labeled green fluid icon button">
					<i class="cart icon"></i>Checkout
				</a>
			</div>

		@endif
		</div>
	</div>

</div>

@endsection

@push('scripts')
<script type="text/javascript">
$('.dropdown').dropdown();
</script>
@endpush