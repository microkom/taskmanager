$(document).ready(function () {

    /**
     * Assign class 'active' to active button by capturing the current url '/assigntask'
     */
    var path = window.location.pathname.substring(1)
    $('#' + path).addClass('active');
});