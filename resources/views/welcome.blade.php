@extends('layout')
@section('welcome')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">


    <table id="pokemonTable" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var nextUrl = @json($nextUrl); // Pass the value of $nextUrl to JavaScript

            var prevUrls = [];

            var table = $('#pokemonTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": nextUrl, // Use the JavaScript variable nextUrl
                    "dataSrc": function (response) {
                        if (response.previous) prevUrls.push(response.previous);
                        nextUrl = response.next;

                        return response.results;
                    }
                },
                "columns": [
                    { "data": "name" },
                    {
                        "data": "url",
                        "render": function(data, type, row, meta) {
                            return '<a href="' + data + '" target="_blank">View Details</a>';
                        }
                    }
                ]
            });

            $('#pokemonTable').on('page.dt', function() {
                var pageInfo = table.page.info();
                if (pageInfo.page + 1 === pageInfo.pages && nextUrl) {
                    table.ajax.url(nextUrl).load();
                } else if (pageInfo.page === 0 && prevUrls.length > 0) {
                    nextUrl = prevUrls.pop();
                    table.ajax.url(nextUrl).load();
                }
            });
        });
    </script>

@endsection