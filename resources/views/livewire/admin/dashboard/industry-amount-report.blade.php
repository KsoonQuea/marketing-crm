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
                    <h5>Industry Approval Amount</h5>
                </div>
            </div>
        </div>

        <div class="table-responsive table-size">
            <table class="table table-border-vertical">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Industry</th>
                        <th scope="col">Approved Amount (RM)</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        arsort($newArray);
                        $no = 1;
                    ?>
                    @foreach($newArray as $key => $industry)
                        <tr>
                            <th scope="row">{{$no++}}</th>
                            <td>
                                @if(App\Models\IndustryType::find($key))
                                    {{App\Models\IndustryType::find($key)->name}}
                                @else
                                    No Industry
                                @endif
                            </td>
                            <td>{{number_format($industry[0])}} (Case : {{number_format($industry[1])}})</td>
                        </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
