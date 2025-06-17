@extends('admin.admin_master')

@section('admin')
<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <!-- عرض رسالة الخطأ -->
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

            <h1>Edit paidprograms</h1>
            <form action="{{ route('admin.paidprograms.update', $paidprograms->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">paidprograms Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $paidprograms->name }}" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" id="description" required>{{ $paidprograms->description }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="university_ID">Select University</label>
                    <select name="university_ID" id="university_ID" class="form-control" required>
                        @foreach($universities as $university)
                            <option value="{{ $university->id }}" 
                                {{ $university->id == $paidprograms->university_ID ? 'selected' : '' }}>
                                {{ $university->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" class="form-control" id="start_date" value="{{ $paidprograms->start_date }}" required>
                </div>
                
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" class="form-control" id="end_date" value="{{ $paidprograms->end_date }}" required>
                </div>
                
                <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" name="cost" class="form-control" id="cost" value="{{ $paidprograms->cost }}">
                </div>
              
                <div class="form-group">
                    <label for="type">Tupe</label>
                    <input type="text" name="type" class="form-control" id="type" value="{{ $scholarship->type }}">
                </div>
                
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" name="country" class="form-control" id="country" value="{{ $paidprograms->country }}">
                </div>
                
                <div class="form-group">
                    <label for="application_url">Application URL</label>
                    <input type="url" name="application_url" class="form-control" id="application_url" value="{{ $paidprograms->application_url }}">
                </div>
                
                <input type="submit" class="btn btn-success" value="Update paidprograms">
                <a href="{{ route('admin.paidprograms.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </section>
    </div>
</div>
@endsection
