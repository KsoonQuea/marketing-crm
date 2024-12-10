<div>
    <style>
        .table-size {
            height: 300px;
            overflow: auto;
        }
    </style>

    <div class="card p-3">
        <div class="mb-4">
            <div class="row">
                <div class="col-6 text-left">
                    <h5>Bank Approval by Industry</h5>
                </div>
                <div class="col-6 text-right">
                    <select class="form-select" wire:model="industry_id">
                        <option>Please Select</option>
                        @foreach($industries as $industry)
                            <option value="{{$industry->id}}">{{$industry->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive table-size">
            <table class="table table-border-vertical">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Bank</th>
                        <th scope="col">Approved</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        arsort($countIndustry);
                        $no = 1;
                    ?>
                    @foreach($countIndustry as $key => $industry)
                        <tr>
                            <th scope="row">{{$no++}}</th>
                            <td>{{App\Models\Bank::find($key)->name}}</td>
                            <td>{{$industry}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
