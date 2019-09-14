<li class="nav-item  {!! url()->current() == route('home') ? 'active' : ''!!}">
	<a class=" nav-link " href="{{  url('/') }}">
		<i class="ni ni-tv-2 text-primary"></i>
		{{ __('menu.Dashboard') }}
	</a>
</li>

@foreach (Auth::user()->userVAT->pluck('vat') as $vat)
<li class="nav-item">
	<a class="nav-link {!! url()->current() == route($vat->route) ? 'active' : ''!!}" href="{{route($vat->route)}}">
		<i class="fas fa-users text-green"></i> {{$vat->name}}
	</a>
</li>
@endforeach