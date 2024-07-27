<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>

<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .table{
        width: 80%;
        margin: 0 auto;
    }

    table{
        width: 100%;
        border-collapse: collapse;
    }

    th, td{
        border: 1px solid #000;
        padding: 10px;
        text-align: center;
    }

    th{
        background-color: #f2f2f2;
    }

    tr:nth-child(even){
        background-color: #f2f2f2;
    }

    tr:hover{
        background-color: #f5f5f5;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
        background-color: #007bff;
        color: #fff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
        background-color: #f2f2f2;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button{
        padding: 10px;
        border: 1px solid #007bff;
        margin: 0 5px;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled{
        background-color: #f2f2f2;
        color: #000;
        cursor: not-allowed;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
        background-color: #007bff;
        color: #fff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
        background-color: #f2f2f2;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button{
        padding: 10px;
        border: 1px solid #007bff;
        margin: 0 5px;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled{
        background-color: #f2f2f2;
        color: #000;
        cursor: not-allowed;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
        background-color: #007bff;
        color: #fff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
        background-color: #f2f2f2;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button{
        padding: 10px;
        border: 1px solid #007bff;
        margin: 0 5px;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled{
        background-color: #f2f2f2;
        color: #000;
        cursor: not-allowed;
    }
    </style>
</head>
<body>

<div class="table">
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>


<script >
let table = new DataTable('#myTable');


</script> 
</body>
</html>