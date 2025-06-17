@extends('admin.admin_master')

@section('admin')
<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <h1>Edit Scholarship</h1>
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
            <form action="{{ route('admin.scholarships.update', $scholarship->scholarships_ID) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Scholarship Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $scholarship->name }}" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" id="description" >{{ $scholarship->description }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="university_ID">Select University</label>
                    <select name="university_ID" id="university_ID" class="form-control" required>
                        @foreach($universities as $university)
                            <option value="{{ $university->id }}" 
                                {{ $university->id == $scholarship->university_ID ? 'selected' : '' }}>
                                {{ $university->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" class="form-control" id="start_date" value="{{ $scholarship->start_date }}" required>
                </div>
                
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" class="form-control" id="end_date" value="{{ $scholarship->end_date }}" required>
                </div>
                
                <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" name="cost" class="form-control" id="cost" value="{{ $scholarship->cost }}">
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <input type="text" name="type" class="form-control" id="type" value="{{ $scholarship->type }}">
                </div>
                
                <div class="form-group">
                    <label for="funding_type">Funding Type</label>
                    <select name="funding_type" class="form-control" id="funding_type">
                        <option value="Full" {{ $scholarship->funding_type == 'Full' ? 'selected' : '' }}>Full</option>
                        <option value="Partial" {{ $scholarship->funding_type == 'Partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="funding_amount">Funding Amount</label>
                    <input type="number" name="funding_amount" class="form-control" id="funding_amount" value="{{ $scholarship->funding_amount }}">
                </div>
                
                <div class="form-group">
                    <label for="eligibility_criteria">Eligibility Criteria</label>
                    <textarea name="eligibility_criteria" class="form-control" id="eligibility_criteria">{{ $scholarship->eligibility_criteria }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" name="country" class="form-control" id="country" value="{{ $scholarship->country }}">
                </div>
                
                <div class="form-group">
                    <label for="application_url">Application URL</label>
                    <input type="url" name="application_url" class="form-control" id="application_url" value="{{ $scholarship->application_url }}">
                </div>
                
                <input type="submit" class="btn btn-rounded btn-info mb-5" value="Update Scholarship">
                <a href="{{ route('admin.scholarships.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </section>
    </div>
</div>
@endsection
