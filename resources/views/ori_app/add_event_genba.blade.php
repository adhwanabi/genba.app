<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Google Material Icons -->
    <link href="{{ asset('css/material-icons.css') }}" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="{{ asset('js/index.global.js') }}"></script>
    <!-- Flatpickr for datetime picker -->
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
    <title>Genba Event Management</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #ebedfd;
            --secondary: #3f37c9;
            --danger: #f72585;
            --warning: #3cff00;
            --success: #4cc9f0;
            --dark: #212529;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: var(--dark);
        }

        /* Sidebar */
        .sidebar {
            background: white;
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu li {
            list-style: none;
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            color: #555;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .sidebar-menu a.active {
            background-color: var(--primary-light);
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }

        .sidebar-menu .material-icons {
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            transition: all 0.3s;
        }

        /* Navbar */
        .navbar {
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar .material-icons {
            cursor: pointer;
        }

        .search-bar {
            position: relative;
            width: 300px;
        }

        .search-bar input {
            padding-left: 2.5rem;
            border-radius: 20px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }

        .search-bar .material-icons {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.8rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-radius: 10px 10px 0 0 !important;
        }

        /* Mobile View */
        @media (max-width: 992px) {
            .sidebar {
                left: -280px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .search-bar {
                width: 200px;
            }
        }

        /* Modal */
        .modal-header {
            border-bottom: 1px solid #eee;
        }

        .modal-footer {
            border-top: 1px solid #eee;
        }

        /* Priority Badges */
        .badge-priority {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .badge-critical {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }

        .badge-high {
            background-color: rgba(248, 150, 30, 0.1);
            color: #f8961e;
        }

        .badge-medium {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .badge-low {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success);
        }

        /* Action Buttons */

        .btn-edit {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .btn-edit:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-delete {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }

        .btn-delete:hover {
            background-color: var(--danger);
            color: white;
        }

        /* Calendar Customization */
        .fc {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .fc-header-toolbar {
            margin-bottom: 1em;
        }

        .fc-toolbar-title {
            font-size: 1.4em;
            font-weight: 600;
            color: var(--dark);
        }

        .fc-button {
            background-color: white !important;
            border: 1px solid #ddd !important;
            color: #555 !important;
            text-transform: capitalize !important;
            font-weight: 500 !important;
            transition: all 0.2s !important;
        }

        .fc-button:hover {
            background-color: #f8f9fa !important;
        }

        .fc-button-primary:not(:disabled).fc-button-active {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
        }

        .fc-daygrid-day-number {
            color: #555;
            font-weight: 500;
        }

        .fc-daygrid-day.fc-day-today {
            background-color: rgba(67, 97, 238, 0.1) !important;
        }

        .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            color: var(--primary);
            font-weight: 700;
        }

        .fc-event {
            border-radius: 6px !important;
            border: none !important;
            padding: 4px 6px !important;
            font-size: 0.85em !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important;
        }

        .fc-event-main {
            padding: 2px 4px !important;
        }

        .fc-event-time {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .fc-event-title {
            font-weight: 500;
        }

        /* Flatpickr Customization */
        .flatpickr-input {
            background-color: white !important;
            border: 1px solid #ced4da !important;
        }

        .flatpickr-calendar {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1) !important;
            border-radius: 10px !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        .flatpickr-time input {
            font-weight: 500 !important;
        }

        .flatpickr-day.selected {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .flatpickr-time .flatpickr-time-separator,
        .flatpickr-time .flatpickr-am-pm {
            color: var(--dark) !important;
        }

        /* Time Input Customization */
        .time-input-container {
            position: relative;
        }

        .time-input-container input {
            padding-right: 40px;
        }

        .time-input-container .time-picker-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <img src="{{ asset('img/company-logo.png') }}" alt="logo API" class="w-25 me-2">
                <span class="sidebar-brand">GENBA APP</span>
            </div>
            <span class="material-icons d-lg-none" id="sidebarClose">close</span>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                    <i class="fas fa-tachometer-alt me-2" style="font-size: 1.2rem;"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bod') }}">
                    <i class="fas fa-tasks me-2" style="font-size: 1.2rem;"></i>
                    <span>BOD</span>
                </a>
            </li>
            <li>
                <a href="{{ route('form') }}" class="d-flex align-items-center">
                    <i class="fas fa-plus-circle me-2" style="font-size: 1.2rem;"></i>
                    <span>Buat Temuan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('genba-event.create') }}" class="active">
                    <i class="fas fa-calendar-plus me-2" style="font-size: 1.2rem;"></i>
                    <span>Tambah Genba Event</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <img src="{{ asset('img/icon/logout.png') }}" alt="Dashboard" style="width:24px;height:24px;"
                        class="me-2">
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <span class="material-icons d-lg-none" id="sidebarToggle">menu</span>

                <div class="ms-auto d-flex align-items-center">
                    <div class="user-profile">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User">
                        <span>Admin</span>
                    </div>
                </div>
            </div>
        </nav>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                <span class="material-icons align-middle me-2">check_circle</span>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                <span class="material-icons align-middle me-2">error</span>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Content -->
        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Genba Event Management</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class="fas fa-plus me-2"></i>Tambah Event
                </button>
            </div>

            <!-- Calendar -->
            <div class="card">
                <div class="card-header">
                    <span>Kalendar Genba Event</span>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Event Mendatang</span>
                    <div class="input-group" style="width: 250px;">
                        <input type="text" id="searchEvent" class="form-control" placeholder="Cari event...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Event</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Prioritas</th>
                                    <th>PIC</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="eventTableBody">
                                <!-- Events will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4" id="paginationContainer">
                        <!-- Pagination will be loaded via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Tambah Genba Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="eventForm" action="{{ route('genba-event.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="eventName" class="form-label">Nama Event</label>
                                <input type="text" class="form-control" id="eventName" name="event_name"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="eventLocation" class="form-label">Lokasi</label>
                                <input type="text" class="form-control" id="eventLocation" name="location"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="startDate" class="form-label">Tanggal Mulai</label>
                                <input type="text" class="form-control flatpickr-datetime" id="startDate"
                                    name="start_date" placeholder="Pilih tanggal dan waktu" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="endDate" class="form-label">Tanggal Selesai</label>
                                <input type="text" class="form-control flatpickr-datetime" id="endDate"
                                    name="end_date" placeholder="Pilih tanggal dan waktu" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="eventPriority" class="form-label">Prioritas</label>
                                <select class="form-select" id="eventPriority" name="priority" required>
                                    <option value="a">Grade A</option>
                                    <option value="b">Grade B</option>
                                    <option value="c">Grade C</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="eventPic" class="form-label">PIC</label>
                                <input type="text" class="form-control" id="eventPic" name="pic" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="eventDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Edit Genba Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editEventForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editEventName" class="form-label">Nama Event</label>
                                <input type="text" class="form-control" id="editEventName" name="event_name"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editEventLocation" class="form-label">Lokasi</label>
                                <input type="text" class="form-control" id="editEventLocation" name="location"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editStartDate" class="form-label">Tanggal Mulai</label>
                                <input type="text" class="form-control flatpickr-datetime" id="editStartDate"
                                    name="start_date" placeholder="Pilih tanggal dan waktu" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editEndDate" class="form-label">Tanggal Selesai</label>
                                <input type="text" class="form-control flatpickr-datetime" id="editEndDate"
                                    name="end_date" placeholder="Pilih tanggal dan waktu" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editEventPriority" class="form-label">Prioritas</label>
                                <select class="form-select" id="editEventPriority" name="priority" required>
                                    <option value="a">Grade A</option>
                                    <option value="b">Grade B</option>
                                    <option value="c">Grade C</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editEventPic" class="form-label">PIC</label>
                                <input type="text" class="form-control" id="editEventPic" name="pic"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editEventDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editEventDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteEventModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus event ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteEventForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (Wajib sebelum Bootstrap JS jika pakai jQuery di bawah) -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- Flatpickr for datetime picker -->
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/id.js') }}"></script>

    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        document.getElementById('sidebarClose').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
        });

        // Initialize datetime picker
        flatpickr(".flatpickr-datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            locale: "id",
            minDate: "today",
            minuteIncrement: 15,
            allowInput: true
        });

        // Initialize Calendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                views: {
                    timeGridWeek: {
                        dayHeaderFormat: {
                            weekday: 'short',
                            day: 'numeric',
                            month: 'short'
                        }
                    },
                    timeGridDay: {
                        dayHeaderFormat: {
                            weekday: 'long',
                            day: 'numeric',
                            month: 'long'
                        }
                    }
                },
                firstDay: 1,
                navLinks: true,
                editable: true,
                dayMaxEvents: true,
                events: {
                    url: '{{ route('genba-event.calendar') }}',
                    method: 'GET',
                    failure: function() {
                        alert('Gagal memuat data event');
                    }
                },
                eventClick: function(info) {
                    // Show event details in a modal when clicked
                    const event = info.event;
                    const startDate = new Date(event.start);
                    const endDate = event.end ? new Date(event.end) : null;

                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    };

                    let eventDetails = `
                        <div class="mb-3">
                            <h5>${event.title}</h5>
                            <hr>
                            <p><strong>Lokasi:</strong> ${event.extendedProps.location || '-'}</p>
                            <p><strong>Mulai:</strong> ${startDate.toLocaleDateString('id-ID', options)}</p>
                            <p><strong>Selesai:</strong> ${endDate ? endDate.toLocaleDateString('id-ID', options) : '-'}</p>
                            <p><strong>PIC:</strong> ${event.extendedProps.pic || '-'}</p>
                            <p><strong>Deskripsi:</strong> ${event.extendedProps.description || '-'}</p>
                        </div>
                    `;

                    // You can replace this with a custom modal if you prefer
                    Swal.fire({
                        title: 'Detail Event',
                        html: eventDetails,
                        icon: 'info',
                        confirmButtonText: 'Tutup'
                    });
                },
                eventContent: function(arg) {
                    // Customize event display with priority-based styling
                    let priorityClass = '';
                    switch (arg.event.extendedProps.priority) {
                        case 'a':
                            priorityClass = 'event-critical';
                            break;
                        case 'b':
                            priorityClass = 'event-high';
                            break;
                        case 'c':
                            priorityClass = 'event-medium';
                            break;
                    }

                    let timeText = '';
                    if (arg.event.allDay) {
                        timeText = 'All Day';
                    } else {
                        timeText = arg.timeText;
                    }

                    let eventElement = document.createElement('div');
                    eventElement.className = `fc-event-main-frame ${priorityClass}`;
                    eventElement.innerHTML = `
                        <div class="fc-event-time">${timeText}</div>
                        <div class="fc-event-title">${arg.event.title}</div>
                    `;

                    return {
                        domNodes: [eventElement]
                    };
                },
                eventDidMount: function(arg) {
                    // Add tooltip to events
                    if (arg.event.extendedProps.description) {
                        $(arg.el).tooltip({
                            title: arg.event.extendedProps.description,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                },
                eventDrop: function(info) {
                    // Handle event drag and drop
                    updateEventDate(info.event);
                },
                eventResize: function(info) {
                    // Handle event resize
                    updateEventDate(info.event);
                }
            });
            calendar.render();

            // Function to update event date after drag/drop or resize
            function updateEventDate(event) {
                const eventId = event.id;
                const startDate = event.start.toISOString();
                const endDate = event.end ? event.end.toISOString() : startDate;

                $.ajax({
                    url: `/genba-event/${eventId}/update-date`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        showAlert('success', 'Event berhasil diperbarui');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        calendar.refetchEvents(); // Revert changes if update fails
                        showAlert('error', 'Gagal memperbarui event');
                    }
                });
            }

            // Load initial event data
            loadEvents(1);

            // Handle form submission
            $('#eventForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addEventModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('#eventForm')[0].reset();

                        // Show success message
                        showAlert('success', response.message);

                        // Refresh calendar and event list
                        calendar.refetchEvents();
                        loadEvents(1);
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        for (const field in errors) {
                            errorMessages += errors[field][0] + '\n';
                        }

                        alert('Error: ' + errorMessages);
                    }
                });
            });

            // Search event
            $('#searchEvent').on('keyup', function() {
                loadEvents(1, $(this).val());
            });
        });

        // Function to load events via AJAX
        function loadEvents(page, search = '') {
            $.ajax({
                url: '{{ route('genba-event.list') }}',
                type: 'GET',
                data: {
                    page: page,
                    search: search
                },
                success: function(response) {
                    updateEventTable(response.data);
                    updatePagination(response);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Function to update event table
        function updateEventTable(events) {
            console.log(events);
            let tbody = $('#eventTableBody');
            tbody.empty();

            if (events.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-calendar-times fa-2x mb-3" style="color:#4361ee;"></i>
                            <div class="fs-5">Tidak ada event ditemukan.</div>
                        </td>
                    </tr>
                `);
                return;
            }

            events.forEach(event => {
                // Format dates
                const startDate = new Date(event.start_date);
                const endDate = new Date(event.end_date);

                const options = {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                };

                const dateRange = `
                    ${startDate.toLocaleDateString('id-ID', options)} - 
                    ${endDate.toLocaleDateString('id-ID', options)}
                `;

                // Priority badge
                let priorityBadge = '';
                switch (event.priority) {
                    case 'a':
                        priorityBadge = '<span class="badge badge-priority badge-critical">Kritis</span>';
                        break;
                    case 'b':
                        priorityBadge = '<span class="badge badge-priority badge-high">Tinggi</span>';
                        break;
                    case 'c':
                        priorityBadge = '<span class="badge badge-priority badge-medium">Sedang</span>';
                        break;
                }

                // Create row
                let row = `
                    <tr>
                        <td>${event.event_name}</td>
                        <td>${dateRange}</td>
                        <td>${event.location}</td>
                        <td>${priorityBadge}</td>
                        <td>${event.pic}</td>
                        <td>
                            <button class="btn btn-edit" onclick="editEvent(${event.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-delete" onclick="confirmDelete(${event.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                tbody.append(row);
            });
        }

        // Function to update pagination
        function updatePagination(pagination) {
            let paginationContainer = $('#paginationContainer');
            paginationContainer.empty();

            if (pagination.last_page <= 1) return;

            let html = `<nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">`;

            // Previous page link
            if (pagination.current_page > 1) {
                html += `<li class="page-item">
                    <a class="page-link" href="#" onclick="loadEvents(${pagination.current_page - 1}, $('#searchEvent').val())" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>`;
            } else {
                html += `<li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>`;
            }

            // Page links
            for (let i = 1; i <= pagination.last_page; i++) {
                html += `<li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadEvents(${i}, $('#searchEvent').val())">${i}</a>
                </li>`;
            }

            // Next page link
            if (pagination.current_page < pagination.last_page) {
                html += `<li class="page-item">
                    <a class="page-link" href="#" onclick="loadEvents(${pagination.current_page + 1}, $('#searchEvent').val())" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>`;
            } else {
                html += `<li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>`;
            }

            html += `</ul></nav>`;
            paginationContainer.html(html);
        }

        // Function to edit event
        function editEvent(eventId) {
            $.ajax({
                url: `/genba-event/${eventId}/edit`,
                type: 'GET',
                success: function(response) {
                    // Populate edit form
                    $('#editEventName').val(response.event_name);
                    $('#editEventLocation').val(response.location);

                    // Format dates for datetime-local input
                    const startDate = new Date(response.start_date);
                    const endDate = new Date(response.end_date);

                    // Initialize flatpickr for edit modal
                    flatpickr("#editStartDate", {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        time_24hr: true,
                        locale: "id",
                        defaultDate: startDate,
                        minuteIncrement: 15,
                        allowInput: true
                    });

                    flatpickr("#editEndDate", {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        time_24hr: true,
                        locale: "id",
                        defaultDate: endDate,
                        minuteIncrement: 15,
                        allowInput: true
                    });

                    $('#editEventPriority').val(response.priority);
                    $('#editEventPic').val(response.pic);
                    $('#editEventDescription').val(response.description);

                    // Set form action
                    $('#editEventForm').attr('action', `/genba-event/${eventId}`);

                    // Show modal
                    $('#editEventModal').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Handle edit form submission
        $('#editEventForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const url = $(this).attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#editEventModal').modal('hide');
                    $('.modal-backdrop').remove();

                    // Show success message
                    showAlert('success', response.message);

                    // Refresh calendar and event list
                    var calendar = FullCalendar.getCalendarById('calendar');
                    calendar.refetchEvents();
                    loadEvents(1);
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '';

                    for (const field in errors) {
                        errorMessages += errors[field][0] + '\n';
                    }

                    alert('Error: ' + errorMessages);
                }
            });
        });

        // Function to confirm delete
        function confirmDelete(eventId) {
            $('#deleteEventForm').attr('action', `/genba-event/${eventId}`);
            $('#deleteEventModal').modal('show');
        }

        // Handle delete form submission
        $('#deleteEventForm').on('submit', function(e) {
            e.preventDefault();
            const url = $(this).attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#deleteEventModal').modal('hide');
                    $('.modal-backdrop').remove();

                    // Show success message
                    showAlert('success', response.message);

                    // Refresh calendar and event list
                    var calendar = FullCalendar.getCalendarById('calendar');
                    calendar.refetchEvents();
                    loadEvents(1);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Function to show alert
        function showAlert(type, message) {
            let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            let icon = type === 'success'
                ? '<i class="fas fa-check-circle me-2"></i>'
                : '<i class="fas fa-exclamation-triangle me-2"></i>';

            let alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show m-4" role="alert">
                    ${icon}
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            // Remove existing alerts
            $('.alert').remove();

            // Add new alert
            $('.main-content').prepend(alertHtml);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        }
    </script>
</body>

</html>
