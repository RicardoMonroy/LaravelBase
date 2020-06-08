@extends('layouts.app', ['activePage' => 'roles-management', 'titlePage' => __('Administración de Roles')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <roleindex-component></roleindex-component>
    </div>
  </div>
@endsection