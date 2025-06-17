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
            <h1>Manage Scholarships</h1>

            <!-- عرض رسالة نجاح عند الإضافة أو التعديل -->
            @if(session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            <!-- زر إضافة منحة جديدة -->
            <a href="{{ route('admin.scholarships.create') }}" class="btn btn-rounded btn-success mb-5">Add New Scholarship</a>

            <!-- جدول عرض المنح الدراسية -->
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Cost</th>
                        <th>Type</th>
                        <th>Funding Type</th>
                        <th>Country</th>
                        <th>University</th> <!-- عرض اسم الجامعة -->
                        <th>Application URL</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($scholarships as $scholarship)
                        <tr>
                            <td>{{ $scholarship->scholarships_ID }}</td>
                            <td>{{ $scholarship->name }}</td>
                            <td>{{ $scholarship->description }}</td>
                            <td>{{ $scholarship->start_date }}</td>
                            <td>{{ $scholarship->end_date }}</td>
                            <td>{{ $scholarship->cost ?? 'N/A' }}</td>
                            <td>{{ $scholarship->type  }}</td>
                            <td>{{ $scholarship->funding_type }}</td>
                            <td>{{ $scholarship->country }}</td>
                            <td>{{ $scholarship->university->name ?? 'N/A' }}</td> <!-- عرض اسم الجامعة هنا -->
                            <td>
                                @if($scholarship->application_url)
                                    <a href="{{ $scholarship->application_url }}" target="_blank">{{ $scholarship->application_url }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.scholarships.edit', $scholarship->scholarships_ID ) }}" class="btn btn-info">Edit</a>

                                <form action="{{ route('admin.scholarships.destroy', $scholarship->scholarships_ID ) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" onclick="return confirm('Are you sure you want to delete this scholarship?')" value="Delete" class="btn btn-danger"/>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</div>
@endsection
