$(document).ready(function() {
    $('#confirmDelete').click(function() {
        $.ajax({
            url: '/courses/{{ course.id }}/delete',
            type: 'POST',
            success: function(result) {
                window.location.href = '/courses';
            },
            error: function(err) {
                alert('Error al eliminar el curso');
            }
        });
    });
});