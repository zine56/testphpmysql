$(document).ready(function() {
    var courseId;

    $('#coursesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });

    $('.delete-course').click(function() {
        courseId = $(this).data('course-id');
        $('#deleteModal').modal('show');
    });

    $('#confirmDelete').click(function() {
        $.ajax({
            url: '/courses/' + courseId + '/delete',
            type: 'POST',
            success: function(result) {
                window.location.href = '/courses';
            },
            error: function(err) {
                alert('Error al eliminar el curso');
            }
        });
    });

    $('#createCourseForm').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: '/courses',
            type: 'POST',
            data: $(this).serialize(),
            success: function(result) {
                $('#createCourseModal').modal('hide');
                window.location.href = '/courses';
            },
            error: function(err) {
                alert('Error al crear el curso');
            }
        });
    });
});