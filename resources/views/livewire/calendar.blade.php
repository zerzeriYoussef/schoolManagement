<head>
    <!-- FullCalendar CSS (only one version) -->
    <link href='https://unpkg.com/@fullcalendar/core@5.11.3/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/daygrid@5.11.3/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/timegrid@5.11.3/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/list@5.11.3/main.min.css' rel='stylesheet' />
</head>

<style>
    #calendar-container {
        position: relative;
        width: 100%;
        margin: 0 auto;
        padding: 20px;
    }
    #calendar {
        margin: 0 auto;
        padding: 10px;
        max-width: 1100px;
        height: 700px;
        box-sizing: border-box;
    }
</style>

<div>
    <div id='calendar-container' wire:ignore>
        <div id='calendar'></div>
    </div>
</div>

@push('scripts')
    <!-- FullCalendar JS (only one version) -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

    <script>
    document.addEventListener('livewire:load', function () {
        const calendarEl = document.getElementById('calendar');

        // Initialize the calendar with plugins and locale
        const calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid', 'timeGrid', 'list'],
            locale: 'fr', // Set the locale to French directly
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            initialView: 'dayGridMonth', // Default view
        });

        // Render the calendar
        calendar.render();
    });
</script>

@endpush
