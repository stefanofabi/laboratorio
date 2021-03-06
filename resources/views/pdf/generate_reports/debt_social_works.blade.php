@extends('pdf/base')


@section('title')
    {{ trans('pdf.social_work_debt_report_from_to', ['start_date' => date('d/m/Y', strtotime($start_date)), 'end_date' => date('d/m/Y', strtotime($end_date))]) }}
@endsection

@section('style')
    <style>
        #first_column {
            position: absolute;
            top: 1%;
            width: 100px;
        }

        #second_column {
            margin-left: 17%;
        }

        .cover {
            background: #FFFFA6;
        }

        .cover td {
            width: 150mm;
        }

        .small {
            width: 25mm;
        }

        .medium {
            width: 40mm;
        }

        .large {
            width: 50mm;
        }

        .billingPeriodsTable td {
            text-align: center;
        }
    </style>
@endsection

@section('header')
    <div id="first_column">
        <img width="80" height="80" src="{{ asset('images/logo.png') }}">
    </div>

    <div id="second_column">
        <table class="cover">
            <tr>
                <td class="title"> {{ trans('pdf.social_work_debt_report_from_to', ['start_date' => date('d/m/Y', strtotime($start_date)), 'end_date' => date('d/m/Y', strtotime($end_date))]) }}
                </td>
            </tr>
        </table>

        <br/>

        <table class="cover">
            <tr>
                <td> Date: {{ date('d/m/Y') }}  </td>
            </tr>

            <tr>
                <td> Generated by: {{ auth()->user()->name }}</td>
            </tr>
        </table>
    </div>
@endsection

@section('body')
    <table class="billingPeriodsTable" style="margin-top: 3%" border="1" cellspacing="0">
        <tr>
            <td class="medium"> <strong> {{ trans('billing_periods.billing_period') }} </strong></td>
            <td class="small"> <strong> {{ trans('billing_periods.start_date') }} </strong> </td>
            <td class="small"> <strong> {{ trans('billing_periods.end_date') }} </strong> </td>
            <td class="large"> <strong> {{ trans('social_works.social_work') }} </strong> </td>
            <td class="medium"> <strong> {{ trans('pdf.total_amount') }} </strong> </td>
        </tr>

        @foreach ($billing_periods as $billing_period)
            <tr>
                <td> {{ $billing_period->name }} </td>
                <td> {{ date('d/m/Y', strtotime($billing_period->start_date)) }} </td>
                <td> {{ date('d/m/Y', strtotime($billing_period->end_date)) }} </td>
                <td> {{ $billing_period->social_work }} </td>
                <td>
                    ${{ number_format($billing_period->total_amount, 2, ',', '.') }}

                    @if ($billing_period->total_amount > 0)
                        ({{ $billing_period->total_paid * 100 / $billing_period->total_amount }}%)
                    @else
                        (0%)
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection
