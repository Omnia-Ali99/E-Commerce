@extends('layouts.dashboard.app')
@section('title')
Roles
@endsection
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Basic Tables</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">{{__('dashboard.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active"><a href="{{route('dashboard.roles.create')}}">{{__('dashboard.create_role')}}</a>
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="dropdown float-md-right">
            <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
            <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton"><a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> Calender</a>
              <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
              <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
        {{-- <a href="{{route("dashboard.roles.create")}}" class="btn btn-primary">{{__('dashboard.add')}}</a><br><br> --}}
        <!-- Basic Tables start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __('dashboard.roles') }}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content ">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col">{{ __('dashboard.role_name') }}</th>
                          <th scope="col">{{ __('dashboard.roles') }} </th>
                          <th scope="col">{{ __('dashboard.operations') }} </th>
                        </tr>
                      </thead>
                      <tbody>
                     @forelse ($roles as $role)
                     <tr>
                      <th scope="row">{{$loop->iteration}}</th>
                      <td>{{$role->role}}</td>
                      <td>
                      @if (Config('app.locale') == 'ar')
                      @foreach ($role->permession as $perm)
                      @foreach (Config::get('permessions_ar') as $key=>$value)
                          {{$key == $perm ? $value . ' , ' : ''}}
                      @endforeach
                      @endforeach
                      @else
                      @foreach ($role->permession as $perm)
                      {{ $perm }},
                      @endforeach
                      @endif
                      </td>

                      <td>
                        <div class="dropdown float-md-left">
                          <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
                          type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('dashboard.operations') }}</button>
                          <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton">
                            <a class="dropdown-item" href="{{ route('dashboard.roles.edit', $role->id) }}"><i class="la  la-edit"></i>{{__('dashboard.edit')}}</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" 
                            href="javascript:void(0)"
                            onclick="if(confirm('Are you sure you want to delete this role?')){document.getElementById('delete-form-{{ $role->id }}').submit();} return false">
                            <i class="la la-trash"></i> {{__('dashboard.delete')}}</a>
                          </div>
                        </div>
                      </td>
                    </tr>


                   {{-- delete form  --}}
                   <form id="delete-form-{{ $role->id }}" action="{{ route('dashboard.roles.destroy', $role->id) }}" method="post">
                      @csrf
                      @method('DELETE')
                    </form> 
                    
                    
                     @empty
                     <td colspan="4">Not Data</td>

                     @endforelse
                      </tbody>
                    </table>
                    {{ $roles->links() }}
                  </div>
                </div>
                
              
              </div>
            </div>
          </div>
        </div>
        <!-- Basic Tables end -->

          </div>
    </div>
  </div>
@endsection