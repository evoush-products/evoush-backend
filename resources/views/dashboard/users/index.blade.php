@extends('layouts.dashboard.global')
@section('title') {{$title}} @endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-xs-12 col-sm-12">
            {{-- Adding user only administrator --}}
            @if(in_array("ADMIN", json_decode(Auth::user()->roles)))
              <a href="{{route('users.create')}}" class="btn btn-sm btn-primary mt-2 mb-3">Create New User</a>
            @endif

            @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif
            <form action="{{route('users.index')}}">
             <div class="input-group mb-3">
               <input
               value="{{Request::get('keyword')}}"
               name="keyword"
               class="form-control col-md-10"
               type="text"
               placeholder="Filter berdasarkan email"/>
               <div class="input-group-append">
                 <input
                 type="submit"
                 value="Filter"
                 class="btn btn-primary">
               </div>
             </div>
           </form>

            <div class="card">
                <div class="card-header">{{ __('List User') }}</div>
                <div class="card-body">
                    <table class="table table-bordered">
                       <thead>
                           <tr>
                               <th><b>Name</b></th>
                               <th><b>Username</b></th>
                               <th><b>Email</b></th>
                               <th><b>Avatar</b></th>
                               <th><b>Status</b></th>
                               <th><b>Roles</b></th>
                               {{-- <th><b>Pencapian</b></th> --}}
                               <th><b>Action</b></th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach($users as $user)
                           <tr>
                               <td>{{$user->name}}</td>
                               <td>{{$user->username}}</td>
                               <td>{{$user->email}}</td>
                               <td>
                                @if($user->avatar)

                                     {{-- @if(in_array("MEMBER", json_decode($user->roles)) || in_array("ADMIN", json_decode($user->roles)) || in_array("STAFF", json_decode($user->roles)) || in_array("WEBDEVELOPER", json_decode($user->roles)) && in_array("AUTHOR", json_decode($user->roles)) || $user->achievements !== NULL )
                                       <img src="https://raw.githubusercontent.com/evoush-products/bahan_evoush/master/migration_db/{{ $user->avatar }}" width="70px">
                                      @else --}}

                                        <img src="{{asset('storage/'.$user->avatar)}}" width="70px">
                                      {{-- @endif --}}
                                @else
                                  <img src="https://raw.githubusercontent.com/codesyariah122/bahan-evoush/master/images/profile/default.jpg" width="80">
                                @endif
                               </td>
                               <td>
                                 @if($user->status == "ACTIVE")
                                 <span class="badge badge-success">
                                   {{$user->status}}
                                 </span>
                                 @else
                                 <span class="badge badge-danger">
                                   {{$user->status}}
                                 </span>
                                 @endif
                               </td>

                               {{-- <td>
                                @if(in_array("MEMBER", json_decode($user->roles)))
                                  @if(in_array("STAR SAPHIRE", json_decode($user->achievements)))
                                    {{"Star Saphire"}}
                                  @elseif(in_array("SAPHIRE", json_decode($user->achievements)))
                                    {{"Saphire"}}
                                  @else
                                    {{"No Achievements"}}
                                  @endif
                                @endif
                               </td> --}}
                               <td>
                                {{-- Management Roles --}}
                                @if(in_array("ADMIN", json_decode($user->roles)))
                                  <span class="badge badge-primary">ADMINISTRATOR</span>
                                @elseif(in_array("STAFF", json_decode($user->roles)))
                                  <span class="badge badge-primary">STAFF</span>
                                @elseif(in_array("AUTHOR", json_decode($user->roles)))
                                  <span class="badge badge-warning">AUTHOR</span>

                                {{-- Membership Roles --}}
                                @elseif(in_array("MEMBER", json_decode($user->roles)))
                                  <span class="badge badge-success">MEMBER</span>
                                @else
                                  <span class="badge badge-danger">FOLLOWER</span>
                                @endif
                               </td>
{{--
                               @if(in_array("STAFF", json_decode(Auth::user()->roles)) == in_array("STAFF", json_decode($user->roles)))
                                <h1>Yeah</h1>
                                @endif --}}
                               <td>
                                @if(Auth::check())
                                  @if(in_array("ADMIN", json_decode(Auth::user()->roles)) || in_array("STAFF", json_decode(Auth::user()->roles)) == in_array("STAFF", json_decode($user->roles)))
                                      <a class="btn btn-info text-white btn-sm" href="{{route('users.edit',
                                     [$user->id])}}">Edit</a>
                                  @endif

                                  {{-- Only Admin --}}
                                  @if(in_array("ADMIN", json_decode(Auth::user()->roles)))
                                     <form
                                         onsubmit="return confirm('Delete this user permanently?')"
                                         class="d-inline"
                                         action="{{route('users.destroy', [$user->id])}}"
                                         method="POST">
                                         @csrf
                                         <input
                                         type="hidden"
                                         name="_method"
                                         value="DELETE">
                                         <input
                                         type="submit"
                                         value="Delete"
                                         class="btn btn-danger btn-sm">
                                    </form>
                                  @endif
                                @endif
                                <a
                                href="{{route('users.show', [$user->id])}}"
                                class="btn btn-primary btn-sm">Detail</a>
                               </td>
                           </tr>
                           @endforeach
                       </tbody>
                       <tfoot>
                         <td colspan="10">
                          {{$users->appends(Request::all())->links()}}
                         </td>
                       </tfoot>
                   </table>

                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    ul li{
        list-style: none;
    }
</style>
@endsection