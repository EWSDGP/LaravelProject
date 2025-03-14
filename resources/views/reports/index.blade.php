@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage Reports</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Reporter</th>
                <th>Idea Title</th>
                <th>Idea Author</th>
                <th>Description</th>
                <th>Reason</th>
                <th>Actions</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->user->name }}</td>
                    <td>{{ $report->idea->title }}</td>
                    <td>{{ $report->idea->user->name }}</td> 
                    <td>{{ $report->idea->description }}</td> 
                    <td>{{ $report->reason }}</td>
                    <td>
                     
                    <form action="{{ route('manage.reports.delete', $report->id) }}" method="POST" style="display:inline;">
                         @csrf
                         @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</button>
                     </form>
                       
                    <form action="{{ route('manage.reports.ban', $report->idea->user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to ban this user?');"
                            {{ $report->idea->user->is_banned ? 'disabled' : '' }}>
                            Ban User
                        </button>
                    </form>

                    <form action="{{ route('manage.reports.unban', $report->idea->user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success" 
                            onclick="return confirm('Unban this user?');"
                            {{ !$report->idea->user->is_banned ? 'disabled' : '' }}>
                            Unban User
                        </button>
                    </form>

                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
