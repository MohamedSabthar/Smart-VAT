<li class="nav-item  {!! url()->current() == route('home') ? 'active' : ''!!}">
    <a class=" nav-link " href="{{  url('/') }}">
        <i class="ni ni-tv-2 text-primary"></i>
        {{ __('menu.Dashboard') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {!! url()->current() == route('manage-employee') ? 'active' : ''!!}"
        href="{{route('manage-employee')}}">
        <i class="fas fa-users text-green"></i> {{__('menu.Employees')}}
    </a>
</li>
<li class="nav-item">
    <a id="allVats" class="nav-link  collapsed" href="#navbar-vats" data-toggle="collapse" role="button"
        aria-expanded="false" aria-controls="navbar-vats">
        <i class="ni ni-align-left-2 text-default"></i>
        <span class="nav-link-text">VAT Categories</span>
    </a>
    <div class="collapse" id="navbar-vats">
        <ul class="nav nav-sm flex-column">
            @foreach (App\Vat::all() as $vat)
            <li class="nav-item">
                <a href="{{route($vat->route)}}" class="nav-link
                    {!! url()->current() == route($vat->route) ? 'active' : ''!!}">
                    {{$vat->name}}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</li>