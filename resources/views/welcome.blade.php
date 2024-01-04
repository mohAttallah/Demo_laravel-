<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon DataTable</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
</head>
<body>
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
            var nextUrl = "https://pokeapi.co/api/v2/pokemon?offset=0&limit=20";
            var prevUrls = [];

            var table = $('#pokemonTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": function (data, callback, settings) {
                    $.ajax({
                        url: nextUrl,
                        success: function(response) {
                            if (response.previous) prevUrls.push(response.previous);
                            nextUrl = response.next;

                            callback({
                                draw: data.draw,
                                recordsTotal: response.count,
                                recordsFiltered: response.count,
                                data: response.results
                            });
                        }
                    });
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
                    table.ajax.reload();
                } else if (pageInfo.page === 0 && prevUrls.length > 0) {
                    nextUrl = prevUrls.pop();
                    table.ajax.reload();
                }
            });
        });
    </script>
</body>
</html>
