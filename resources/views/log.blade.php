@extends('layouts.app')
@section('content')
<div class="container">
    <h3 align="center" style="margin-bottom: 20px">Laravel v5.8 - implementation of SMSEdge test task</h3>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <select name="records" id="records" class="form-control" required>
                    <option value="50">50 records/day</option>
                    <option value="100">100 records/day</option>
                    <option value="200">200 records/day</option>
                    <option value="500">500 records/day</option>
                    <option value="1000">1000 records/day</option>
                </select>
            </div>
        </div>
        <div class="col-md-8"></div>
    </div>

    <div class="row input-daterange">
        <div class="col-md-4">
            <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
        </div>
        <div class="col-md-4">
            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
        </div>
        <div class="col-md-4">
            <button type="button" name="generate" id="generate" class="btn btn-primary">Generate</button>
        </div>
    </div>
    <br />
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="order_table">
            <thead>
            <tr>
                <th>User ID</th>
                <th>Number ID</th>
                <th>Log message</th>
                <th>Log success</th>
                <th>Log created</th>
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

        function load_data(from_date = '', to_date = '', records = 0, action = '') {
            $('#order_table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                ajax: {
                    url:'{{ route("log.index") }}',
                    data:{from_date:from_date, to_date:to_date, records:records, action:action}
                },
                columns: [
                    {
                        data:'usr_id'
                    },
                    {
                        data:'num_id'
                    },
                    {
                        data:'log_message'
                    },
                    {
                        data:'log_success'
                    },
                    {
                        data:'log_created'
                    }
                ]
            });
        }
        load_data();

        $('#generate').click(function() {
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();
            let records = $('#records').val();
            if (from_date !== '' &&  to_date !== '') {
                $('#order_table').DataTable().destroy();
                load_data(from_date, to_date, records, 'generate');
            }
            else
            {
                alert('Both Date is required');
            }
        });

    });
</script>
@endsection
