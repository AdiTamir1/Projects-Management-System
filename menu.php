<table style="width: 100%;">
    <tr>
        <td><button onclick="window.location.href='main.php'">Main</button></td>
    <?php
    if( $_SESSION['role'] == "ad" ) { ?>
        <td><button onclick="window.location.href='companies.php'">Manage Companies</button></td>
        <td><button onclick="window.location.href='departments.php'">Manage Departments</button></td>
        <td><button onclick="window.location.href='projects.php'">Manage Projects</button></td>
        <td><button onclick="window.location.href='add_user.php'">Add User</button></td>
        <td><button onclick="window.location.href='add_user.php'">New Employee</button></td>
        
    <?php
    } else if( $_SESSION['role'] == "pm" ) { ?>
        <td><button onclick="window.location.href='assign_employee_to_project.php'">Assign Employee to Project</button></td>
        <td><button onclick="window.location.href='add_task.php'">Add Task</button></td>
    <?php
    } else if( $_SESSION['role'] == "tl" ) { ?>
        <td><button onclick="window.location.href='employees.php'">Manage Employees</button></td>
        <td><button onclick="window.location.href='add_task.php'">Add Task</button></td>
        <td><button onclick="window.location.href='employee_tasks.php'">Employee Tasks</button></td>
        <td><button onclick="window.location.href='project_tasks_statuses.php'">Project Statuses Report</button></td>
    <?php }
    else if( $_SESSION['role'] == "tw" ) { ?>
        <td><button onclick="window.location.href='my_tasks.php'">My Tasks</button></td>
    <?php }
    ?>
        <td><button onclick="window.location.href='logout.php'">Logout</button></td>
    </tr>
</table>
