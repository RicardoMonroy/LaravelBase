@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('Administración de Usuarios')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <userindex-component></userindex-component>
    </div>
  </div>
@endsection