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
            <h1>Manage Universities</h1>

            <!-- عرض رسالة نجاح عند الإضافة أو التعديل -->
            @if(session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            <!-- زر إضافة جامعة جديدة -->
            <a href="{{ route('admin.universities.create') }}" class="btn btn-rounded btn-success mb-5">Add New University</a>

            <!-- جدول عرض الجامعات -->
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Established Year</th>
                        <th>Website</th>
                        <th>Description</th>
                        <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($universities as $university)
                        <tr>
                            <td>{{ $university->id }}</td>
                            <td>{{ $university->name }}</td>
                            <td>{{ $university->location }}</td>
                            <td>{{ $university->established_year }}</td>
                            <td>
                                @if($university->website)
                                    <a href="{{ $university->website }}" target="_blank">{{ $university->website }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $university->description ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.universities.edit', $university->id) }}" class="btn btn-info">Edit</a>
                                <form action="{{ route('admin.universities.destroy', $university->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" onclick="return confirm('Are you sure you want to delete this university?')" value="Delete" class="btn btn-danger"/>
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
