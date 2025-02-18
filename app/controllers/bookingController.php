<?phpnamespace controllers;require_once  '../model/booking.php';require_once '../../Helper/ErrorMessage.php';require_once  '../model/student.php';use Exception;use model\booking;use model\student;use ErrorMessage;class bookingController{    public function storeBooking():void    {        $Fields = [            'name' => 'name is required',            'StudentId' => 'Student Id is required',            'email'  => 'email is required',            'date'  => 'date is required',        ];        $data = [];        $error = [];        foreach($Fields as $Field => $message){            if (!isset($_POST[$Field]) || trim($_POST[$Field]) === '') { // check if each input is Empty or no value                $error[$Field] = $message;            }else{                $data[$Field] = htmlspecialchars($_POST[$Field]);            }        }        if (!empty($error)) { // check if the error array is not empty            $data['success'] = false;            $data['errors'] = $error;            echo json_encode($data);            return;        }        $booking = new booking();        $student = new student();             //-------------Checker----------------------        if ($student->studentIdChecker($data['StudentId'])){            $booking->store(                $data['name'],                $data['date'],                $data['email'],                $data['StudentId'],            );        }else{            ErrorMessage::JsonResponse(false, 'Sorry, the Student ID you entered does not exist in our records. Please check and try again.');        }    }    public function filterByStudentId()    {        $studentId = htmlspecialchars($_POST['studentId']);        if (empty($studentId)) {            echo "        <script>            Swal.fire({                title: 'Oops!',                text: 'Please provide student ID',                icon: 'error'            });        </script>    ";            return;        }        $booking = new booking();        $student = new student();        $tr_table = '';        //-------------Checker----------------------        if ($student->studentIdChecker($studentId)){           $data = $booking->filterByStudentId($studentId);           if ($data){               foreach ($data as $row){                   $tr_table .= '                    <tr>                        <td>'.$row['studentName'].'</td>                        <td>'.$row['studentId'].'</td>                        <td>'.$row['bookingDate'].'</td>                        <td>'.$row['email'].'</td>                        <td>'.$row['status'].'</td>                   </tr>                   ';               }               echo $tr_table;           }        }else{            echo "            <script>                Swal.fire({                    title: 'Oops!',                    text: 'Sorry, the Student ID you entered does not exist in our records. Please check and try again',                    icon: 'error'                });            </script>    ";        }    }    public static function countBooking()    {        $model = new booking();        $card = '          <span class="fw-bold"> '.$model->CountBooked().'</span>        ';        echo $card;    }    public function updateStatus()    {        $Id = htmlspecialchars($_POST['Id']);        $status = htmlspecialchars($_POST['status']);        if (empty($Id)){            ErrorMessage::JsonResponse(false, 'No Id Provided');            return;        }        if (empty($status)){            ErrorMessage::JsonResponse(false, 'no status selected');            return;        }        $booking = new booking();        $booking->UpdateStatus(            $status,            $Id        );    }    public static  function showToAdmin()    {        $booking = new booking();        $tr_table = '';        $data = $booking->showAll();        if ($data){            foreach ($data as $row){                $statusClass = '';                switch ($row['status']){                    case 'Pending':                        $statusClass = "bg-primary";                        break;                    case 'Confirmed':                        $statusClass = 'bg-success';                        break;                    case 'Canceled':                        $statusClass = 'bg-danger';                        break;                }                $tr_table .= '                    <tr>                        <td>'.$row['id'].'</td>                        <td>'.$row['studentName'].'</td>                        <td>'.$row['studentId'].'</td>                        <td>'.$row['bookingDate'].'</td>                        <td>'.$row['email'].'</td>                      <td>                         <span class="badge bg-opacity-75 p-2 '.$statusClass.'"> '.$row['status'].'</span>                    </td>                            <td>                            <input type="hidden" id="bookingId" value="'.$row['id'].'">                               <button id="delete_btn" value="'.$row['id'].'" class="btn btn-danger">Delete</button>                                  <div class="badge">                                    <select id="update_status_select" name="status" class="form-select" aria-label="Default select example">                                      <option value="" selected>Update</option>                                       <option value="Canceled">Cancel</option>                                        <option value="Confirmed">Confirm</option>                                     </select>                                   </div>                                </td>                        </tr>                   ';            }        }        echo $tr_table;    }}if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])){    match ($_POST['action']){        'store' => (new bookingController())->storeBooking(),        'filter' => (new bookingController())->filterByStudentId(),        'update' => (new bookingController())->updateStatus(),        default => http_response_code(400)    };}