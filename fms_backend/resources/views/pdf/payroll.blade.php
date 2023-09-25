<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Pay Slip</title>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center lh-1 mb-2">
                    <h6 class="fw-bold">Pay Roll</h6> <span class="fw-normal">Payment slip for the month of {{$monthYear}}</span>
                </div>
                <!-- <div class="d-flex justify-content-end"> <span>Working Branch:ROHINI</span> </div> -->
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <div> <span class="fw-bolder">Employee Name</span> <small class="ms-3">{{$name}}</small> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div> <span class="fw-bolder">Designation</span> <small class="ms-3">Driver</small> </div>
                            </div>
                            <div class="col-md-6">
                                <div> <span class="fw-bolder">Ac No.</span> <small class="ms-3">*******{{$acc_no}}</small> </div>
                            </div>
                        </div>
                    </div>
                    <table class="mt-4 table table-bordered">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th scope="col">Earnings</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Deductions</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Basic Salary</th>
                                <td>{{$basic}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Allowances</th>
                                <td>{{$allowance}}</td>
                                <th scope="row">Deductions</td>
                                <td>{{$deduction}}</td>
                            </tr>
                            <tr class="border-top">
                                <th scope="row">Total Earning</th>
                                <td>{{$total_earning}}</td>
                                <th scope="row">Total Deductions</td>
                                <td>{{$deduction}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="border col-md-12  bg-light">
                        <div class="d-flex p-2 flex-column"> <span class="fw-bold">Net Pay : <span class="fw-normal"> {{$net_salary}}</span>  </span></div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="d-flex flex-column mt-4"> <span class="fw-bolder">Last Mile Fleet Management System</span> <span class="mt-2">Authorised Signatory</span> </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>