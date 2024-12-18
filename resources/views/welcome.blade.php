@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

<div class="container-fluid bg-dark text-white">
    <div class="row">
        <div class="col-md-12">
            <header class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4">
                <h1 class="h2">Dashboard</h1>
                <div>
                    <span class="me-3">April 18, 2021</span>
                    <input type="text" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
                </div>
            </header>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card bg-secondary text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Good Morning, Eleanor</h5>
                    <p>Welcome to your daily event calendar. Here you can see all the upcoming events, meetings, and create new events.</p>
                    <button class="btn btn-light">+ Create Event</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Reminder</h5>
                    <ul class="list-unstyled">
                        <li>Training sessions 10:00 AM</li>
                        <li>Team meetings 1:00 PM</li>
                    </ul>
                    <button class="btn btn-light">+ Add New</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-dark text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Contacts</h5>
                    <ul class="list-unstyled">
                        <li>Martin Black - Coach</li>
                        <li>Jane Cooper - Manager</li>
                        <li>Jacob Jones - Player</li>
                        <li>Albert Flores - Player</li>
                    </ul>
                    <button class="btn btn-light">View All</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card bg-dark text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Half Year Work Results</h5>
                    <div id="workResultsChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-dark text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Schedule</h5>
                    <div class="calendar">
                        <div class="d-flex justify-content-between">
                            <span>April, 2021</span>
                            <button class="btn btn-light btn-sm">View All</button>
                        </div>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Sun</th>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thu</th>
                                    <th>Fri</th>
                                    <th>Sat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4</td>
                                    <td>5</td>
                                    <td>6</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>8</td>
                                    <td>9</td>
                                    <td>10</td>
                                    <td>11</td>
                                    <td>12</td>
                                    <td>13</td>
                                </tr>
                                <tr>
                                    <td>14</td>
                                    <td>15</td>
                                    <td>16</td>
                                    <td>17</td>
                                    <td>18</td>
                                    <td>19</td>
                                    <td>20</td>
                                </tr>
                                <tr>
                                    <td>21</td>
                                    <td>22</td>
                                    <td>23</td>
                                    <td>24</td>
                                    <td>25</td>
                                    <td>26</td>
                                    <td>27</td>
                                </tr>
                                <tr>
                                    <td>28</td>
                                    <td>29</td>
                                    <td>30</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card bg-dark text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Schedule</h5>
                    <ul class="list-unstyled">
                        <li>Team meetings - B&H Football Club, 1:15 PM - 4:00 PM</li>
                        <li>Medical checks - BD & Treatment Centre, 4:15 PM - 6:00 PM</li>
                    </ul>
                    <button class="btn btn-light">View All</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        chart: {
            type: 'line',
            height: 300,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Training sessions',
            data: [3, 5, 2, 8, 6, 9]
        }, {
            name: 'Team meetings',
            data: [2, 3, 4, 5, 7, 8]
        }, {
            name: 'Medical checks',
            data: [1, 2, 3, 4, 5, 6]
        }],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
        },
        colors: ['#00E396', '#008FFB', '#FF4560'],
        stroke: {
            curve: 'smooth'
        },
        markers: {
            size: 5
        },
        tooltip: {
            shared: true,
            intersect: false
        }
    };

    var chart = new ApexCharts(document.querySelector("#workResultsChart"), options);
    chart.render();
</script>
@endsection
