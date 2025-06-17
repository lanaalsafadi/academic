@extends('layout')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5" style="font-weight: bold; color: #333;">Scholarships</h1>

    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <form method="GET" action="{{ route('scholarships.search') }}">
                <div class="row">
                    <!-- University Dropdown -->
                    <div class="col-md-4 mb-3">
                        <select name="university" class="form-control">
                            <option value="">Select University</option>
                            @foreach($universities as $university)
                                <option value="{{ $university->name }}" {{ request('university') == $university->name ? 'selected' : '' }}>
                                    {{ $university->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                     <!-- Type Dropdown -->
                     <div class="col-md-4 mb-3">
                        <select name="type" class="form-control">
                            <option value="">Select Type of Scholarships</option>
                            @foreach($type as $types)
                                <option value="{{ $types->type }}" {{ request('types') == $types->type ? 'selected' : '' }}>
                                    {{ $types->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Country Dropdown -->
                    <div class="col-md-4 mb-3">
                        <select name="place" class="form-control">
                            <option value="">Select Country</option>
                            @foreach($countries as $countries)
                                <option value="{{ $countries->country }}" {{ request('place') == $countries->country ? 'selected' : '' }}>
                                    {{ $countries->country }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                  
                    <!-- Funding Type Dropdown -->
                    <div class="col-md-4 mb-3">
                        <select name="fundingType" class="form-control">
                            <option value="">Select Funding Type</option>
                            <option value="Full" {{ request('fundingType') == 'Full' ? 'selected' : '' }}>Fully Funded</option>
                            <option value="Partial" {{ request('fundingType') == 'Partial' ? 'selected' : '' }}>Partially Funded</option>
                        </select>
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" style="background-color: #ffc107; color: #fff; border-radius: 25px; padding: 10px 30px; font-weight: bold;" value="Search">
                </div>
            </form>
        </div>
    </div>
    <!-- Scholarships List -->
    <div class="row">
        @forelse($scholarships as $scholarship)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card scholarship-card">
                <!-- Card Header -->
                <div class="card-header scholarship-card-header">
                    {{ $scholarship->name }}
                </div>
                <!-- Card Body -->
                <div class="card-body scholarship-card-body">
                    <p><strong>Description:</strong> {{ $scholarship->description }}</p>
                    <p><strong>Country:</strong> {{ $scholarship->country }}</p>
                    <p><strong>Type Scholarships:</strong> {{ $scholarship->type }}</p>
                    <p><strong>University Name:</strong> {{ $scholarship->university->name }}</p>
                    <p><strong>Funding Type:</strong> {{ $scholarship->funding_type }}</p>
                    <p><strong>Cost:</strong> {{ $scholarship->cost ? '$' . $scholarship->cost : 'N/A' }}</p>
                    <p><strong>Eligibility:</strong> {{ $scholarship->eligibility_criteria }}</p>
                    <p><strong>Start Date:</strong> {{ $scholarship->start_date }}</p>
                    <p><strong>End Date:</strong> {{ $scholarship->end_date }}</p>
                </div>
                <!-- Card Footer -->
                <div class="card-footer scholarship-card-footer">
                    <!-- إذا كانت هناك رسالة نجاح -->
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


                    @auth('student')
                    <form action="{{ route('submitScholarshipRequest') }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ auth('student')->user()->id }}">
                        <input type="hidden" name="scholarship_id" value="{{ $scholarship->scholarships_ID }}">
                        <input type="hidden" name="type" value="{{$scholarship->type}}">
                        <input type="hidden" name="funding_type" value="{{ $scholarship->funding_type }}">
                        <input type="submit" value="Apply Now" class="scholarship-apply-btn">
                    </form>
                        
                    @else
                        <a href="index" class="scholarship-login-btn" title="​Please login">Login to Apply</a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No scholarships found matching your criteria.</p>
        @endforelse
    </div>
</div>
@endsection
