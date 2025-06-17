@extends('layout')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5" style="font-weight: bold; color: #333;">Paidprograms</h1>




    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <form method="GET" action="{{ route('paidprograms.search') }}">
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
                            <option value="">Select Type of PaidPrograms</option>
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
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" style="background-color: #ffc107; color: #fff; border-radius: 25px; padding: 10px 30px; font-weight: bold;" value="Search">
                </div>
            </form>
        </div>
    </div>





    <div class="row">
        @forelse($paidprograms as $paidprogram)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card scholarship-card">
                <!-- Card Header -->
                <div class="card-header scholarship-card-header">
                    {{ $paidprogram->name }}
                </div>
                <!-- Card Body -->
                <div class="card-body scholarship-card-body">
                    <p><strong>Description:</strong> {{ Str::limit($paidprogram->description, 100) }}</p>
                    <p><strong>Country:</strong> {{ $paidprogram->country }}</p>
                    <p><strong>Type PaidPrograms:</strong> {{ $paidprogram->type }}</p>
                    <p><strong>University Name:</strong> {{ $paidprogram->university->name }}</p>
                    <p><strong>Cost:</strong> {{ $paidprogram->cost ? '$' . $paidprogram->cost : 'N/A' }}</p>
                    <p><strong>start_date:</strong> {{ $paidprogram->start_date }}</p>
                    <p><strong>end_date:</strong> {{ $paidprogram->end_date }}</p>
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
                    <form action="{{ route('submitPaidProgramRequest') }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ auth('student')->user()->id }}">
                        <input type="hidden" name="paid_program_id" value="{{ $paidprogram->id }}">
                        <input type="submit" value="Apply Now" class="scholarship-apply-btn">
                    </form>
                        
                    @else
                        <a href="index"class="scholarship-login-btn" title="​Please login">Login to Apply</a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No paidprograms found matching your criteria.</p>
        @endforelse
    </div>
</div>
@endsection