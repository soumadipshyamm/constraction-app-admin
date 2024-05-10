<!DOCTYPE html>
<html>

<head>
    <title> Import and Export Excel data to database Using Laravel 5.8 </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    {{-- {{ $status }} --}}
    <div class="container">
        <div class="card bg-light mt-3">
            <div class="card-header">
                Import and Export Excel data to database Using Laravel 5.8
            </div>
            <div class="card-body">


                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button"
                        aria-expanded="false" aria-controls="collapseExample">
                        Link with href
                    </a><a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a>
                    <a class="btn btn-warning" href="{{ route('demoExport') }}">Demo Import Unit Data</a>

                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <input type="file" name="file" class="form-control" required>
                            <br>
                            <button class="btn btn-success">Import User Data</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
