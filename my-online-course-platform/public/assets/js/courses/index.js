$(document).ready(function() {
    var courseId;

    $('#coursesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });

    $('.view-course').click(function() {
        courseId = $(this).data('course-id');
        $.ajax({
            url: '/courses/' + courseId,
            type: 'GET',
            success: function(course) {
                $('#courseId').val(course.id);
                $('#courseTitle').text(course.title);
                $('#courseDescription').text(course.description);
                $('#courseStatus').text(course.status);
                $('#viewCourseModal').modal('show');
            },
            error: function(err) {
                alert('Error al obtener los detalles del curso');
            }
        });
    });

    $('#saveCourse').click(function() {
        var courseData = $('#editCourseForm').serialize();
        $.ajax({
            url: '/courses/' + $('#courseId').val(),
            type: 'POST',
            data: courseData,
            success: function(result) {
                $('#viewCourseModal').modal('hide');
                window.location.href = '/courses';
            },
            error: function(err) {
                alert('Error al actualizar el curso');
            }
        });
    });

    $('#deleteCourse').click(function() {
        $.ajax({
            url: '/courses/' + $('#courseId').val() ,
            type: 'DELETE',
            success: function(result) {
                $('#viewCourseModal').modal('hide');
                window.location.href = '/courses';
            },
            error: function(err) {
                alert('Error al eliminar el curso');
            }
        });
    });

    $('.delete-course').click(function() {
        courseId = $(this).data('course-id');
        $('#deleteModal').modal('show');
    });

    $('#confirmDelete').click(function() {
        $.ajax({
            url: '/courses/' + courseId ,
            type: 'DELETE',
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
