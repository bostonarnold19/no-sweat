<div class="mb-4">
    {{ Form::label('name', null, ['class' => 'form-label']) }}
    {{ Form::text('name', $permission->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
    {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="mb-4">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>