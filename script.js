
function to2(t) { return (t<10 ? "0"+t : t ); }
function get_today()
{
    var today = new Date();
    return today.getFullYear()+'-'+to2(today.getMonth()+1)+'-'+to2(today.getDate())+" "+
        to2(today.getHours()) + ":" +to2(today.getMinutes()) + ":" + to2(today.getSeconds());
}

function delete_department( d_id ) {
    if( confirm( "Are you sure?")) {
        window.location.href = 'departments.php?action=delete&d_id='+d_id;
    }
}

function delete_company( c_id ) {
    if( confirm( "Are you sure?")) {
        window.location.href = 'companies.php?action=delete&c_id='+c_id;
    }
}

function delete_project( p_id ) {
    if( confirm( "Are you sure?")) {
        window.location.href = 'projects.php?action=delete&p_id='+p_id;
    }
}

function delete_task( e_id, t_id ) {
    if( confirm( "Are you sure?")) {
        window.location.href = 'employee_tasks.php?e_id='+e_id+'&t_id='+t_id;
    }
}

function remove_employee( e_id ) {
    if( confirm( "Are you sure?")) {
        window.location.href = 'remove_employee.php?e_id=' + e_id;
    }
}
