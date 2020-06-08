@extends('layouts.app', ['activePage' => 'permissions-management', 'titlePage' => __('Administración de Permisos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <permissionindex-component></permissionindex-component>
    </div>
  </div>
@endsection