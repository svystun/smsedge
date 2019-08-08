@extends('layouts.app')
@section('content')
<div class="container">
    <h3 align="center" style="margin-bottom: 20px">Laravel v5.8 - implementation of SMSEdge test task</h3>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <select name="country_id" id="country_id" class="form-control" required>
                    <option value="">All Countries</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->cnt_id }}">{{ $country->cnt_title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->usr_id }}">{{ $user->usr_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>

    <div class="row input-daterange">
        <div class="col-md-4">
            <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
        </div>
        <div class="col-md-4">
            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
        </div>
        <div class="col-md-4">
            <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
            <button type="button" name="reset" id="reset" class="btn btn-default">Reset</button>
        </div>
    </div>
    <br />
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="order_table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Successfully sent</th>
                <th>Failed</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(function() {
        $('.input-daterange').datepicker({
            todayBtn:'linked',
            format:'yyyy-mm-dd',
            autoclose:true
        });

        function load_data(from_date = '', to_date = '', country_id = '', user_id = '') {
            $('#order_table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                ajax: {
                    url:'{{ route("log-aggregated2.index2") }}',
                    data:{from_date:from_date, to_date:to_date, country_id:country_id, user_id:user_id}
                },
                columns: [
                    {
                        data:'agg_date'
                    },
                    {
                        data:'success'
                    },
                    {
                        data:'failed'
                    }
                ]
            });
        }
        load_data();

        $('#filter').click(function(){
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();
            let country_id = $('#country_id').val();
            let user_id = $('#user_id').val();
            if (from_date !== '' &&  to_date !== '') {
                $('#order_table').DataTable().destroy();
                load_data(from_date, to_date, country_id, user_id);
            }
            else
            {
                alert('Both Date is required');
            }
        });

        $('#reset').click(function(){
            $('#country_id').val('');
            $('#user_id').val('');
            $('#from_date').val('');
            $('#to_date').val('');
            $('#order_table').DataTable().destroy();
            load_data();
        });

        $('#country_id').on('change', function() {
            $('#user_id').val('');
        });

        $('#user_id').on('change', function() {
            $('#country_id').val('');
        });

    });
</script>
@endsection
