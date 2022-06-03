<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>How to create url shortener</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <h1>How to create url shortener</h1>

    <div class="card">
      <div class="card-header">
        <form method="POST" action="{{ route('generate.shorten.link.post') }}">
            @csrf
            <div class="input-group mb-3">
              <input type="text" name="link" class="form-control" placeholder="Enter URL" aria-label="Recipient's username" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-success" type="submit">Generate Shorten Link</button>
              </div>
            </div>
        </form>
      </div>
      <div class="card-body">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Short Link</th>
                        <th>Original Link</th>
                        <th>Created</th>
                        <th>Last Visited</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shortLinks as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td><a href="javascript:void(0)" target="" id="click_lik" data-id="{{$row->id}}">{{ route('shorten.link', $row->code) }}</a></td>
                            <td>{{ $row->link }}</td>
                            <td>{{date_format($row->created_at,"d-M-y H:i:s") }}</td>
                            <td>{!! ($row->last_visited)?date("d-M-y H:i:s", strtotime($row->last_visited)):'' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
      </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function(){
        $(document).on('click', '#click_lik', function(){
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('click.last') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data){
                    const { status, redirect_link } = data;
                    if(status == 'success'){
                        window.open(redirect_link, '_blank');
                        location.reload();
                    }
                }
            });
        });
    });

</script>
</html>
