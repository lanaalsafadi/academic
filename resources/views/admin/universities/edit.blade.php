@extends('admin.admin_master')

@section('admin')
    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                @if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<!-- عرض رسالة النجاح -->
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
                <h1>Edit University</h1>

                <form action="{{ route('admin.universities.update', $university->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">University Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $university->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" class="form-control" id="location" value="{{ $university->location }}" required>
                    </div>

                    <div class="form-group">
                        <label for="established_year">Established Year</label>
                        <input type="number" name="established_year" class="form-control" id="established_year" value="{{ $university->established_year }}" required>
                    </div>

                    <div class="form-group">
                        <label for="website">Website (optional)</label>
                        <input type="url" name="website" class="form-control" id="website" value="{{ $university->website }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Description (optional)</label>
                        <textarea name="description" class="form-control" id="description">{{ $university->description }}</textarea>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Update University"> 
                    <a href="{{ route('admin.universities.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </section> 
        </div>
    </div>
@endsection
