<div class="form-group">
    <div class="text-center">
        @if (isAdminPanel())
            @include('admin.partials.back')
            <button type="submit" class="btn btn-default">{{ $button }}</button>
        @else
            @include('layouts.partials.back')
            <button type="submit" class="btn btn-theme">{{ $button }}</button>
        @endif
    </div>
</div>