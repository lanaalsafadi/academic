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
            <h1>All Students</h1>
            
            <!-- عرض رسالة نجاح عند الإضافة أو التعديل -->
            @if(session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            <!-- جدول عرض الطلاب -->
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->age }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>
                                
                                <form action="{{ route('admin.student.destroy', $student->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Block" onclick="return confirm('Are you sure you want to Block this student?')" >
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
