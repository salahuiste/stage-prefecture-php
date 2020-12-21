<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="js.min/bootstrap-table.min.js"></script>
<script type="text/javascript" src="js.min/Chart.bundle.min.js"></script>
<script type="text/javascript" src="js.min/datatable.min.js"></script>
<link rel="stylesheet" href="css.min/bootstrap-table.min.css">
<link rel="stylesheet" href="css.min/datatable.min.css">
</head>
<body>
<table class="table datatable"
       data-json="data2.json"
       data-id-field="name"
       data-sort-name="value1"
       data-sort-order="desc"
       data-pagination="false"
       data-show-pagination-switch="false">
    <thead>
        <tr>
            <th data-field="code" data-sortable="true">Name</th>
            <th data-field="value1" data-sortable="true" data-value-type="float2-percentage">Value 1</th>
            <th data-field="value2" data-sortable="true" data-value-type="float4">Value 2</th>
            <th data-field="list" data-sortable="true" data-value-type="list">List</th>
            <th data-field="anchor" data-sortable="true" data-value-type="anchor">Anchor</th>
            <th data-field="url" data-sortable="true" data-value-type="url">URL</th>
            <th data-field="ref" data-sortable="true" data-value-type="ref">References</th>
        </tr>
    </thead>
</table>
</body>
</html>