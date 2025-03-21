@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">📊 System Statistics</h1>

    <div class="row">
       
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📌 Ideas Submitted per Department</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($ideasPerDepartment as $dept)
                            <li class="list-group-item">{{ $dept->name }}: <strong>{{ $dept->ideas_count }}</strong></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

       
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">🏆 Top Contributors</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($ideasPerStaff as $user)
                            <li class="list-group-item">{{ $user->name }}: <strong>{{ $user->ideas_count }}</strong></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

       
        <div class="col-md-6 mt-3">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">📂 Ideas per Category</h5>
                </div>
                <div class="card-body">
                    @foreach($ideasPerCategory as $data)
                        <p class="mb-1">{{ $data->category->category_name }}: <strong>{{ $data->total }}</strong> ideas</p>
                    @endforeach
                </div>
            </div>
        </div>

       
        <div class="col-md-6 mt-3">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📅 Ideas per Academic Year</h5>
                </div>
                <div class="card-body">
                    @foreach($ideasPerYear as $data)
                        <p class="mb-1">{{ $data->year }}: <strong>{{ $data->total }}</strong> ideas</p>
                    @endforeach
                </div>
            </div>
        </div>

        
        <div class="col-md-6 mt-3">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">🕵️ Anonymous vs Named Submissions</h5>
                </div>
                <div class="card-body">
                    <p>🔒 Anonymous: <strong>{{ $anonymousCount }}</strong></p>
                    <p>👤 Named: <strong>{{ $namedCount }}</strong></p>
                </div>
            </div>
        </div>

      
        <div class="col-md-6 mt-3">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">📈 User Engagement</h5>
                </div>
                <div class="card-body">
                    <p>💡 Active Users: <strong>{{ $activeUsersCount }}</strong></p>
                    <p>👥 Total Users: <strong>{{ $totalUsers }}</strong></p>
                    <p>👍 Only Voted/Commented: <strong>{{ $onlyVotedOrCommented }}</strong></p>
                    <p>🚫 Inactive Users: <strong>{{ $inactiveUsers }}</strong></p>
                </div>
            </div>
        </div>

       
        <div class="col-md-6 mt-3">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">🔥 Most Popular Ideas</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($mostPopularIdeas as $idea)
                            <li class="list-group-item">
                                <strong>{{ $idea->title }}</strong> (By: {{ $idea->user->name }}) - ❤️ Likes: {{ $idea->likes }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

      
        <div class="col-md-6 mt-3">
            <div class="card shadow">
                <div class="card-header bg-light text-dark">
                    <h5 class="mb-0">❄️ Least Popular Ideas</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($leastPopularIdeas as $idea)
                            <li class="list-group-item">
                                <strong>{{ $idea->title }}</strong> (By: {{ $idea->user->name }}) - 👎 Dislikes: {{ $idea->dislikes }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let cards = document.querySelectorAll(".card");
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = "1";
                card.style.transform = "translateY(0)";
            }, index * 150);
        });
    });
</script>

@endsection
