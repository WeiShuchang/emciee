@if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
@if(session('success'))
<div class="alert alert-success" role="alert" id="alert-message">
    {{ session('success') }}
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger" id="alert-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif