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
      Edit User
      </h3>
    </div>
    <div class="block-content">
      <form class="mb-5" method="POST" action="{{ route('users.update', [$user->id]) }}" role="form" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        @csrf
        @include('user::user.form')
      </form>
    </div>
  </div>
  <!-- END Your Block -->
</div>
<!-- END Page Content -->
@endsection