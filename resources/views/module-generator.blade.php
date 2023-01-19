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
            <h1 class="flex-grow-1 fs-3 fw-semibold my-1 my-sm-2">Module Generator</h1>
        </div>
    </div>
</div>
<!-- END Hero -->
<!-- Page Content -->
<div class="content">
    <!-- Your Block -->
    <!-- Striped Table -->
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <div class="flex-shrink-0">
            <i class="fa fa-fw fa-info-circle"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            <p class="mb-0">INFO: If you generate a module without a model field value, it will use the module field value</p>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Module Generator</h3>
        </div>
        <div class="block-content">
            <form method="POST" action="{{ route('module-generator.store') }}">
                @csrf
                <div class="mb-4">
                    <input type="text" list="modules" class="form-control form-control-alt" name="module" placeholder="Module" required autofocus autocomplete="off">
                    <datalist id="modules">
                        @foreach($modules as $module)
                        <option value="{{$module}}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="mb-4">
                    <input type="text" class="form-control form-control-alt" name="model" placeholder="Model" autocomplete="off">
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn w-100 btn-hero btn-primary">
                    <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Create Module
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- END Striped Table -->
    <!-- END Your Block -->
</div>
<!-- END Page Content -->
@endsection