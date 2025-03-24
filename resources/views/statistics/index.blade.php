@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mb-4 text-center">📊 System Statistics</h1>

    <div class="row">
        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📌 Ideas Submitted per Department</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">🏆 Top Contributors</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="contributorsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">📂 Ideas per Category</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📅 Ideas per Academic Year</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="yearChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">🕵️ Anonymous vs Named Submissions</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="submissionTypeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">📈 User Engagement</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="userEngagementChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">🔥 Most Popular Ideas</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="popularIdeasChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-light text-dark">
                    <h5 class="mb-0">❄️ Least Popular Ideas</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="leastPopularIdeasChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.card-body {
    position: relative;
    padding: 1rem;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Define the data at the top level
const chartData = {
    department: {
        labels: {!! json_encode($ideasPerDepartment->pluck('name')) !!},
        data: {!! json_encode($ideasPerDepartment->pluck('ideas_count')) !!}
    },
    contributors: {
        labels: {!! json_encode($ideasPerStaff->pluck('name')) !!},
        data: {!! json_encode($ideasPerStaff->pluck('ideas_count')) !!}
    },
    category: {
        labels: {!! json_encode($ideasPerCategory->pluck('category.category_name')) !!},
        data: {!! json_encode($ideasPerCategory->pluck('total')) !!}
    },
    year: {
        labels: {!! json_encode($ideasPerYear->pluck('year')) !!},
        data: {!! json_encode($ideasPerYear->pluck('total')) !!}
    },
    submissionType: {
        labels: ['Anonymous', 'Named'],
        data: [{{ $anonymousCount }}, {{ $namedCount }}]
    },
    userEngagement: {
        labels: ['Active Users', 'Only Voted/Commented', 'Inactive Users'],
        data: [{{ $activeUsersCount }}, {{ $onlyVotedOrCommented }}, {{ $inactiveUsers }}]
    },
    popularIdeas: {
        labels: {!! json_encode($mostPopularIdeas->pluck('title')) !!},
        data: {!! json_encode($mostPopularIdeas->pluck('likes')) !!}
    },
    leastPopularIdeas: {
        labels: {!! json_encode($leastPopularIdeas->pluck('title')) !!},
        data: {!! json_encode($leastPopularIdeas->pluck('dislikes')) !!}
    }
};

document.addEventListener("DOMContentLoaded", function() {
    // Helper function to safely get element
    function getElement(id) {
        const element = document.getElementById(id);
        if (!element) {
            console.error(`Element with id '${id}' not found`);
            return null;
        }
        return element;
    }

    // Helper function to safely create chart
    function createChart(element, config) {
        if (!element) return null;
        return new Chart(element, {
            ...config,
            options: {
                ...config.options,
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });
    }

    // Common chart options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    boxWidth: 12,
                    padding: 15
                }
            }
        }
    };

    // Department Chart
    createChart(getElement('departmentChart'), {
        type: 'bar',
        data: {
            labels: chartData.department.labels,
            datasets: [{
                label: 'Ideas Count',
                data: chartData.department.data,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: commonOptions
    });

    // Contributors Chart
    createChart(getElement('contributorsChart'), {
        type: 'bar',
        data: {
            labels: chartData.contributors.labels,
            datasets: [{
                label: 'Ideas Count',
                data: chartData.contributors.data,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: commonOptions
    });

    // Category Chart
    createChart(getElement('categoryChart'), {
        type: 'bar',
        data: {
            labels: chartData.category.labels,
            datasets: [{
                label: 'Ideas Count',
                data: chartData.category.data,
                backgroundColor: 'rgba(255, 206, 86, 0.5)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: commonOptions
    });

    // Year Chart
    createChart(getElement('yearChart'), {
        type: 'bar',
        data: {
            labels: chartData.year.labels,
            datasets: [{
                label: 'Ideas Count',
                data: chartData.year.data,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: commonOptions
    });

    // Submission Type Chart
    createChart(getElement('submissionTypeChart'), {
        type: 'bar',
        data: {
            labels: chartData.submissionType.labels,
            datasets: [{
                label: 'Submission Count',
                data: chartData.submissionType.data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: commonOptions
    });

    // User Engagement Chart
    createChart(getElement('userEngagementChart'), {
        type: 'bar',
        data: {
            labels: chartData.userEngagement.labels,
            datasets: [{
                label: 'User Count',
                data: chartData.userEngagement.data,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: commonOptions
    });

    // Popular Ideas Chart
    createChart(getElement('popularIdeasChart'), {
        type: 'bar',
        data: {
            labels: chartData.popularIdeas.labels,
            datasets: [{
                label: 'Likes',
                data: chartData.popularIdeas.data,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: commonOptions
    });

    // Least Popular Ideas Chart
    createChart(getElement('leastPopularIdeasChart'), {
        type: 'bar',
        data: {
            labels: chartData.leastPopularIdeas.labels,
            datasets: [{
                label: 'Dislikes',
                data: chartData.leastPopularIdeas.data,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: commonOptions
    });
});
</script>
@endsection
