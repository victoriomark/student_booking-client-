<!doctype html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport"          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    <meta http-equiv="X-UA-Compatible" content="ie=edge">    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <title>Home</title>    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    <style>        #hero_page{            background-position: center;            background-repeat: no-repeat;            background-size: cover;            height: 60vh;            background-image: linear-gradient(to bottom, rgba(53, 56, 19, 0.5), rgba(16, 12, 12, 0.8)), url('assets/img/bg.jpg');        }    </style></head><body><nav class="navbar navbar-expand-lg bg-warning sticky-top">    <div class="container-fluid">        <a class="navbar-brand" href="#">Logo</a>        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">            <span class="navbar-toggler-icon"></span>        </button>        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">            <div class="navbar-nav">                <a class="nav-link active" aria-current="page" href="#">Home</a>                <a class="nav-link" href="#">Announcement</a>                <a data-bs-target="#BookModal" data-bs-toggle="modal" class="nav-link" href="#">Book Now</a>            </div>        </div>    </div></nav><section id="hero_page" class="d-flex flex-column justify-content-center align-items-center">    <form id="searchForm" class="container mt-5">        <h1 class="text-center text-light mb-3">Enter your Student ID to view your booking details.</h1>        <div class="input-group">        <span class="input-group-text bg-white border-end-0">          <i class="fa-solid fa-magnifying-glass"></i>        </span>            <input name="studentId" type="text" class="form-control border-start-0 p-3" placeholder="Enter your Student Id">            <button type="submit" class="btn btn-warning">Search</button>        </div>    </form></section><div class="card mb-4">    <div class="card-header">        <i class="fas fa-table me-1"></i>        Booking Details    </div>    <div class="card-body">        <table class="table table-responsive">            <thead>            <tr>                <th>Name</th>                <th>Student Id</th>                <th>Date</th>                <th>Email</th>                <th>Status</th>            </tr>            </thead>            <tbody id="tbody">            </tbody>        </table>    </div></div><!-- Modal for Booking --><form class="modal fade" id="BookModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">    <div class="modal-dialog modal-dialog-centered">        <div class="modal-content">            <div class="modal-header">                <h1 class="modal-title fs-5" id="staticBackdropLabel">New Book</h1>                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>            </div>            <div class="modal-body">                <div class="form-floating mb-3">                    <input name="name" type="text" class="form-control" id="name" placeholder="Full Name">                    <label for="name">Full Name</label>                    <div id="name_msg" class="invalid-feedback"></div>                </div>                <div class="form-floating mb-3">                    <input name="StudentId" type="text" class="form-control" id="StudentId" placeholder="Student Id">                    <label for="StudentId">Student Id</label>                    <div id="StudentId_msg" class="invalid-feedback"></div>                </div>                <div class="form-floating mb-3">                    <input  name="email" type="email" class="form-control" id="email" placeholder="name@example.com">                    <label for="email">Email address</label>                    <div id="email_msg" class="invalid-feedback"></div>                </div>                <div class="form-floating mb-3">                    <input min="<?= date('Y-m-d') ?>" name="date" type="date" class="form-control" id="date">                    <label for="Date">Date</label>                    <div id="date_msg" class="invalid-feedback"></div>                </div>            </div>            <div class="modal-footer">                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                <button type="submit" class="btn btn-primary">Book Now</button>            </div>        </div>    </div></form><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script><script src="app/JQUERY/booking.js"></script></body></html><script>    $(document).ready(function (){        $(document).on('submit','#searchForm',function (event){            event.preventDefault()            const DataForm = new FormData(this)            DataForm.append('action','filter')            $.ajax({                url: './app/controllers/bookingController.php',                type: 'POST',                data: DataForm,                contentType: false,                processData: false,                success: function (data){                    $('#tbody').html(data)                    console.log(data)                }            })        })    })</script>