@extends('layouts.app')


@section('content')
<div class="container">
    <h1 class="mb-4">System Statistics</h1>

    <h2>Number of Ideas Submitted per Department</h2>
    <ul>
        @foreach($ideasPerDepartment as $dept)
            <li>{{ $dept->name }}: {{ $dept->ideas_count }}</li>
        @endforeach
    </ul>

    <h2>Top Contributors (Ideas Submitted per Staff Member)</h2>
    <ul>
        @foreach($ideasPerStaff as $user)
            <li>{{ $user->name }}: {{ $user->ideas_count }}</li>
        @endforeach
    </ul>

    <h2>Number of Ideas Submitted per Category</h2>
    <ul>
    @foreach($ideasPerCategory as $data)
    <p>{{ $data->category->category_name }}: {{ $data->total }} ideas</p>
@endforeach

    </ul>

    <h2>Number of Ideas Submitted per Academic Year</h2>
    <ul>
    @foreach($ideasPerYear as $data)
    <p>{{ $data->year }}: {{ $data->total }} ideas</p>
@endforeach

    </ul>

    <h2>Anonymous vs Named Submissions</h2>
    <p>Anonymous Submissions: {{ $anonymousCount }}</p>
    <p>Named Submissions: {{ $namedCount }}</p>

    <h2>User Engagement</h2>
    <p>Users Who Submitted at Least One Idea: {{ $activeUsersCount }}</p>
    <p>Total Registered Staff Users: {{ $totalUsers }}</p>
    <p>Users Who Only Voted or Commented: {{ $onlyVotedOrCommented }}</p>
    <p>Users Who Never Engaged: {{ $inactiveUsers }}</p>

<h3>Most Popular Ideas</h3>
<ul>
    @foreach($mostPopularIdeas as $idea)
        <li>
            <strong>{{ $idea->title }}</strong> (Submitted by: {{ $idea->user->name }}) - Likes: {{ $idea->likes }}
        </li>
    @endforeach
</ul>


<h3>Least Popular Ideas</h3>
<ul>
    @foreach($leastPopularIdeas as $idea)
        <li>
            <strong>{{ $idea->title }}</strong> (Submitted by: {{ $idea->user->name }}) - Dislikes: {{ $idea->dislikes }}
        </li>
    @endforeach
</ul>

</div>
@endsection