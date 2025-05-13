<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      
        @can('categories')
              <li class=" nav-item"><a href="index.html"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{__('dashboard.categories')}}</span><span class="badge badge badge-info badge-pill float-right mr-2">{{$categories_count}}</span></a>
                <ul class="menu-content">
                  <li class="active"><a class="menu-item" href="{{route('dashboard.categories.index')}}" data-i18n="nav.dash.ecommerce">{{__('dashboard.categories')}}</a>
                  </li>
                  <li><a class="menu-item" href="{{route('dashboard.categories.create')}}" data-i18n="nav.dash.crypto">{{__('dashboard.category_create')}}</a>
                  </li>
                </ul>
              </li>
        @endcan

        @can('brands')
        <li class=" nav-item"><a href="{{route('dashboard.brands.index')}}"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{__('dashboard.brands')}}</span><span class="badge badge badge-info badge-pill float-right mr-2">{{$brands_count}}</span></a>
          <ul class="menu-content">
            <li class="active"><a class="menu-item" href="{{route('dashboard.brands.index')}}" data-i18n="nav.dash.ecommerce">{{__('dashboard.brands')}}</a>
            </li>
            <li><a class="menu-item" href="{{route('dashboard.brands.create')}}" data-i18n="nav.dash.crypto">{{__('dashboard.brand_create')}}</a>
            </li>
          </ul>
        </li>
  @endcan 
        @can('roles')
        <li class=" nav-item"><a href="#"><i class="la la-television"></i><span class="menu-title" data-i18n="nav.templates.main">{{ __('dashboard.roles') }}</span></a>
          <ul class="menu-content">
            <li><a class="menu-item" href="{{route('dashboard.roles.create')}}" data-i18n="nav.templates.vert.main">{{__('dashboard.create_role')}}</a>
              
              <li><a class="menu-item" href="{{route('dashboard.roles.index')}}" data-i18n="nav.templates.vert.classic_menu">{{__('dashboard.roles')}}</a>
            </li>
          </ul>
        </li>
        @endcan
        @can('admins')
        <li class=" nav-item"><a href="#"><i class="la la-user-secret"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('dashboard.admins') }}</span>
          <span class="badge badge badge-info badge-pill float-right mr-2">{{ $admins_count }}</span>
        </a>
            <ul class="menu-content">
                <li>
                    <a class="menu-item" href="{{ route('dashboard.admins.create') }}" data-i18n="">{{ __('dashboard.create_admin') }} </a>
                </li>
                <li>
                    <a class="menu-item" href="{{ route('dashboard.admins.index') }}" data-i18n="">{{ __('dashboard.admins') }}</a>
                </li>
            </ul>
        </li>
        @endcan

        @can('global_shipping')
        <li class=" nav-item"><a href="#"><i class="la la-ambulance"></i><span class="menu-title" data-i18n="nav.templates.main"> {{ __('dashboard.shipping') }} </span></a>
            <ul class="menu-content">
                <li>
                    <a class="menu-item" href="{{ route('dashboard.countries.index') }}" data-i18n="">{{ __('dashboard.shippping') }}</a>
                </li>

            </ul>
        </li>
        @endcan
        
      


 
      </ul>
    </div>
  </div>