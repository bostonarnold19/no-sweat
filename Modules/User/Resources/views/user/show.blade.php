@extends('layouts.backend')
@section('js')
<!-- jQuery -->
<script src="{{ asset('js/lib/jquery.min.js') }}"></script>
<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<!-- Page JS Code -->
@include('includes.notifications')
@endsection
@section('content')
<!-- Hero -->
<div class="bg-body-light">
  <div class="content content-full">
    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
      <h1 class="flex-grow-1 fs-3 fw-semibold my-1 my-sm-2">Users</h1>
    </div>
  </div>
</div>
<!-- END Hero -->
<!-- Page Content -->
<div class="content">
  <!-- Your Block -->
  <div class="block block-rounded">
    <div class="block-header block-header-default">
      <h3 class="block-title">
      View User
      </h3>
    </div>
    <div class="block-content">
      <div class="mb-5">
        <div class="mb-4">
          <strong>ID</strong><br>
          <p>{{ $user->id }}</p>
        </div>
        <div class="mb-4">
          <strong>First Name</strong><br>
          <p>{{ $user->first_name }}</p>
        </div>
        <div class="mb-4">
          <strong>Middle Name</strong><br>
          <p>{{ $user->middle_name }}</p>
        </div>
        <div class="mb-4">
          <strong>Last Name</strong><br>
          <p>{{ $user->last_name }}</p>
        </div>
        <div class="mb-4">
          <strong>Username</strong><br>
          <p>{{ $user->username }}</p>
        </div>
        <div class="mb-4">
          <strong>Email</strong><br>
          <p>{{ $user->email }}</p>
        </div>
      </div>
    </div>
  </div>
  <!-- END Your Block -->
</div>
<!-- END Page Content -->
@endsection