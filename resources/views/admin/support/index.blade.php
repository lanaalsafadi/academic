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
            <h1>All Supports</h1>
             <!-- عرض رسالة نجاح عند الإضافة أو التعديل -->
             @if(session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif
            <a href="{{ route('admin.support.create') }}" class="btn btn-primary">Add New Support</a>
            
            <!-- جدول عرض المنح الدراسية -->
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supports as $support)
                        <tr>
                            <td>{{ $support->id }}</td>
                            <td>{{ $support->name }}</td>
                            <td>{{ $support->email }}</td>
                            <td>{{ $support->admin ? $support->admin->name : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.support.edit', $support->id) }}" class="btn btn-info">Edit</a>
                                <form action="{{ route('admin.support.destroy', $support->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit"class="btn btn-danger" value="Delete" onclick="return confirm('Are you sure you want to delete this support?')" >
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
