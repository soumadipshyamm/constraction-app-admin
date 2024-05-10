<!-- resources/views/pdf/sample.blade.php -->
<!DOCTYPE html>
<html>

<head>
    {{-- <title>{{ $title }}</title> --}}
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .activity-head {
            text-align: center;
        }

        .projects {
            width: 100%;
            height: 50px;
            margin: 1px;
            padding-top: 10px;
        }

        .priject {
            width: 50%;
            float: left;
        }

        .subpriject {
            width: 50%;
            float: left;
        }

        table {
            width: 100%
        }
    </style>
</head>

<body>
    @foreach ($datas as $key => $value)
        <h1>Daily Progress Report</h1>
        <div class="date">
            Date:{{ $value->date ?? '' }}
        </div>
        <div class="projects">
            <div class="priject"> Projects:{{ $value->projects->project_name ?? '' }}</div>
            <div class="subpriject"> Sub-Projects:{{ $value->subProjects->name ?? '' }}</div>
        </div>
        <h3>Activities</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="11">Activities</td>
                </tr> --}}
                {{-- @foreach ($value->activities as $key => $activity)
                    <tr>
                        <td>{{ $activity->activities->activities ?? '' }}</td>
                        <td>{{ $activity->qty ?? '' }}</td>
                        <td>{{ $activity->total_qty ?? '' }}</td>
                        <td>{{ $activity->remaining_qty ?? '' }}</td>
                        <td>{{ $activity->completion ?? '' }}</td>
                        <td>{{ $activity->vendors->name ?? '' }}</td>
                        <td>{{ $activity->remarkes ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <br><br>
        {{-- *************************************Assets**************************************************************** --}}
        <h3>Assets</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="11">Assets</td>
                </tr> --}}
                {{-- @foreach ($value->assets as $key => $asset)
                    <tr>
                        <td>{{ $asset->assets->name ?? '' }}</td>
                        <td>{{ $asset->qty ?? '' }}</td>
                        <td>{{ $asset->activities->activities ?? '' }}</td>
                        <td>{{ $asset->vendors->name ?? '' }}</td>
                        <td>{{ $asset->rate_per_unit ?? '' }}</td>
                        <td>{{ $asset->remarkes ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <br><br>
        {{-- **************************************Material*************************************************************** --}}
        <h3>Material</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="11"></td>
                </tr> --}}
                {{-- @foreach ($value->material as $key => $materialData)
                    <tr>
                        <td>{{ $materialData->materials->name ?? '' }}</td>
                        <td>{{ $materialData->activities->activities ?? '' }}</td>
                        <td>{{ $materialData->qty ?? '' }}</td>
                        <td>{{ $materialData->remarkes ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Labour********************************************************* --}}
        <h3>Labour</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="7">Labour</td>
                </tr> --}}
                {{-- @foreach ($value->labour as $key => $labourData)
                    <tr>
                        <td>{{ $labourData->vendors->name ?? '' }}</td>
                        <td>{{ $labourData->labours->name ?? '' }}</td>
                        <td>{{ $labourData->activities->activities ?? '' }}</td>
                        <td>{{ $labourData->qty ?? '' }}</td>
                        <td>{{ $labourData->ot_qty ?? '' }}</td>
                        <td>{{ $labourData->rate_per_unit ?? '' }}</td>
                        <td>{{ $labourData->remarkes ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Historie********************************************************* --}}
        <h3>Historie</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="7">Historie</td>
                </tr> --}}
                {{-- @foreach ($value->historie as $key => $historieData)
                    <tr>
                        <td>{{ $historieData->name ?? '' }}</td>
                        <td>{{ $historieData->date ?? '' }}</td>
                        <td>{{ $historieData->details ?? '' }}</td>
                        <td>{{ $historieData->remarks ?? '' }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td>{{ $safetieData->name ?? '' }}</td>
                        <td>{{ $safetieData->date ?? '' }}</td>
                        <td>{{ $safetieData->details ?? '' }}</td>
                        <td>{{ $safetieData->remarks ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    @endforeach
</body>

</html>
{{-- @dd($activity->companys) --}}
{{-- @dd($activity->vendors->name) --}}
{{-- @dd($activity->activities) --}}
{{-- @dd( $activity->activities->project) --}}
{{-- @dd( $activity->activities->subproject) --}}
{{-- @dd($value->assets->toArray()) --}}
{{-- @dd($value->toArray()) --}}
{{-- @dd($value->activities->toArray()) --}}
{{-- @dd($value->labour->toArray()) --}}
{{-- @dd($value->material->toArray()) --}}
{{-- @dd($value->historie->toArray()) --}}
{{-- @dd($value->safetie->toArray()) --}}
{{--
array:1 [ // app\Http\Controllers\API\DprController.php:137
  0 => array:23 [
    "id" => 12
    "uuid" => "9902b7e7-5fce-4769-881e-4eccc0b3e7b7"
    "name" => "2023-10-31"
    "date" => "2024-03-06"
    "staps" => 3
    "projects_id" => 3
    "sub_projects_id" => 1
    "activities_id" => null
    "assets_id" => null
    "labours_id" => null
    "company_id" => 1
    "materials_id" => null
    "hinderance_id" => null
    "is_active" => 1
    "created_at" => "2024-02-28T12:24:06.000000Z"
    "updated_at" => "2024-02-28T13:29:02.000000Z"
    "user_id" => 1
    "assets" => array:2 [
      0 => array:14 [
        "id" => 1
        "uuid" => "7952be3a-d7e5-47cf-b2dc-495eeffddec8"
        "assets_id" => 1
        "qty" => 252
        "activities_id" => 138
        "vendors_id" => 1
        "rate_per_unit" => "12"
        "remarkes" => "testtttt"
        "dpr_id" => 12
        "company_id" => 1
        "is_active" => 1
        "created_at" => "2024-02-28T16:07:13.000000Z"
        "updated_at" => "2024-03-11T13:40:59.000000Z"
        "deleted_at" => null
      ]
      1 => array:14 [
        "id" => 17
        "uuid" => "f6a94a17-d6c3-49e9-8a86-75742c3ad669"
        "assets_id" => 2
        "qty" => 254
        "activities_id" => 139
        "vendors_id" => 1
        "rate_per_unit" => "12"
        "remarkes" => "testtttt"
        "dpr_id" => 12
        "company_id" => 1
        "is_active" => 1
        "created_at" => "2024-03-11T13:40:46.000000Z"
        "updated_at" => "2024-03-11T13:41:09.000000Z"
        "deleted_at" => null
      ]
    ]
    "activities" => array:2 [
      0 => array:16 [
        "id" => 143
        "uuid" => "a72ae969-74ab-4934-849f-78a6789309d1"
        "activities_id" => 139
        "qty" => 1200
        "total_qty" => "2500"
        "remaining_qty" => ""
        "completion" => 44
        "vendors_id" => 1
        "img" => ""
        "remarkes" => "testtttt"
        "company_id" => 1
        "dpr_id" => 12
        "is_active" => 1
        "created_at" => "2024-03-01T11:37:58.000000Z"
        "updated_at" => "2024-03-11T11:42:45.000000Z"
        "deleted_at" => null
      ]
      1 => array:16 [
        "id" => 154
        "uuid" => "780bb2b9-6516-4a5b-aa3d-d8fe098a072e"
        "activities_id" => 138
        "qty" => 2270
        "total_qty" => ""
        "remaining_qty" => ""
        "completion" => 54
        "vendors_id" => 1
        "img" => ""
        "remarkes" => "testtttt"
        "company_id" => 1
        "dpr_id" => 12
        "is_active" => 1
        "created_at" => "2024-03-11T11:38:50.000000Z"
        "updated_at" => "2024-03-11T11:38:50.000000Z"
        "deleted_at" => null
      ]
    ]
    "labour" => array:2 [
      0 => array:15 [
        "id" => 18
        "uuid" => "98975266-de1f-4497-a22b-02d6e74290e7"
        "labours_id" => 1
        "qty" => 213
        "ot_qty" => 253
        "activities_id" => 137
        "vendors_id" => 1
        "rate_per_unit" => "15"
        "remarkes" => "testtdfdddddddddddddttt"
        "company_id" => 1
        "dpr_id" => 12
        "is_active" => 1
        "created_at" => "2024-03-06T13:35:46.000000Z"
        "updated_at" => "2024-03-11T15:10:42.000000Z"
        "deleted_at" => null
      ]
      1 => array:15 [
        "id" => 20
        "uuid" => "b0605e03-ee2e-4fdf-8b7b-8fc6b9533e78"
        "labours_id" => 3
        "qty" => 1390
        "ot_qty" => 135
        "activities_id" => 138
        "vendors_id" => 1
        "rate_per_unit" => "14"
        "remarkes" => "testtttt"
        "company_id" => 1
        "dpr_id" => 12
        "is_active" => 1
        "created_at" => "2024-03-11T15:10:28.000000Z"
        "updated_at" => "2024-03-11T15:10:42.000000Z"
        "deleted_at" => null
      ]
    ]
    "material" => array:3 [
      0 => array:14 [
        "id" => 11
        "uuid" => "481c08a7-3edf-4649-9d18-311eb0b0e7ca"
        "materials_id" => 2
        "activities_id" => 183
        "qty" => 1230
        "date" => null
        "vendors_id" => null
        "remarkes" => "rrr3333333rrrrrrrrrrrrrrr"
        "company_id" => 1
        "dpr_id" => 12
        "is_active" => 1
        "created_at" => "2024-03-11T12:06:40.000000Z"
        "updated_at" => "2024-03-11T12:07:25.000000Z"
        "deleted_at" => null
      ]
      1 => array:14 [
        "id" => 12
        "uuid" => "ac3c7b33-812d-4e1b-8447-e65e52ba5379"
        "materials_id" => 1
        "activities_id" => 184
        "qty" => 130
        "date" => null
        "vendors_id" => null
        "remarkes" => "sssssssssssssssssssswqqqqqqqqqqqqqqqqqq"
        "company_id" => 1
        "dpr_id" => 12
        "is_active" => 1
        "created_at" => "2024-03-11T12:06:40.000000Z"
        "updated_at" => "2024-03-11T12:07:25.000000Z"
        "deleted_at" => null
      ]
      2 => array:14 [
        "id" => 13
        "uuid" => "c5e60b61-ac35-4ac1-8d14-77a93bbe0c0a"
        "materials_id" => 2
        "activities_id" => 184
        "qty" => 120
        "date" => null
        "vendors_id" => null
        "remarkes" => "rrr3333333rrrrrrrrrrrrrrr"
        "company_id" => 1
        "dpr_id" => 12
        "is_active" => 1
        "created_at" => "2024-03-11T12:07:58.000000Z"
        "updated_at" => "2024-03-11T12:08:14.000000Z"
        "deleted_at" => null
      ]
    ]
    "historie" => array:1 [
      0 => array:15 [
        "id" => 10
        "uuid" => "bdc4c17c-bf5c-4c62-bac0-d04104689a6f"
        "name" => "test hinderance"
        "date" => "2024-04-02"
        "details" => ""Test hinderance""
        "remarks" => ""test hinderance remarks""
        "company_users_id" => 4
        "projects_id" => 10
        "sub_projects_id" => 3
        "company_id" => 1
        "dpr_id" => 12
        "img" => "170867480218.png"
        "is_active" => 1
        "created_at" => "2024-02-23T07:53:22.000000Z"
        "updated_at" => "2024-02-23T07:53:22.000000Z"
      ]
    ]
    "safetie" => array:1 [
      0 => array:15 [
        "id" => 13
        "uuid" => "205e2c73-4a00-4729-8941-33eddb0b2827"
        "name" => "iiiiiiiiiiiiiiiiiii"
        "date" => "2024-05-01"
        "details" => "Safety"
        "remarks" => "This policy Only Labours"
        "company_users_id" => null
        "projects_id" => 10
        "sub_projects_id" => 3
        "dpr_id" => 12
        "img" => null
        "company_id" => 1
        "is_active" => 1
        "created_at" => "2024-02-23T07:25:26.000000Z"
        "updated_at" => "2024-02-23T07:25:26.000000Z"
      ]
    ]
  ]
] --}}
