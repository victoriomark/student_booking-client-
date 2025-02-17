<?phpnamespace controllers;require_once  '../model/booking.php';require_once '../../Helper/ErrorMessage.php';require_once  '../model/student.php';use Exception;use model\booking;use model\student;class bookingController{    public function storeBooking():void    {        $Fields = [            'name' => 'name is required',            'StudentId' => 'Student Id is required',            'email'  => 'email is required',            'date'  => 'date is required',        ];        $data = [];        $error = [];        foreach($Fields as $Field => $message){            if (!isset($_POST[$Field]) || trim($_POST[$Field]) === '') { // check if each input is Empty or no value                $error[$Field] = $message;            }else{                $data[$Field] = htmlspecialchars($_POST[$Field]);            }        }        if (!empty($error)) { // check if the error array is not empty            $data['success'] = false;            $data['errors'] = $error;            echo json_encode($data);            return;        }        $booking = new booking();        $student = new student();             //-------------Checker----------------------        if ($student->studentIdChecker($data['StudentId'])){            $booking->store(                $data['name'],                $data['date'],                $data['email'],                $data['StudentId'],            );        }else{            \ErrorMessage::JsonResponse(false, 'Sorry, the Student ID you entered does not exist in our records. Please check and try again.');        }    }    public function filterByStudentId()    {        $studentId = htmlspecialchars($_POST['studentId']);        if (empty($studentId)){            \ErrorMessage::JsonResponse(false, 'please enter your student Id');            return;        }        $booking = new booking();        $student = new student();        $tr_table = '';        //-------------Checker----------------------        if ($student->studentIdChecker($studentId)){           $data = $booking->filterByStudentId($studentId);           if ($data){               foreach ($data as $row){                   $tr_table .= '                    <tr>                        <td>'.$row['studentName'].'</td>                        <td>'.$row['studentId'].'</td>                        <td>'.$row['bookingDate'].'</td>                        <td>'.$row['email'].'</td>                        <td>'.$row['status'].'</td>                   </tr>                   ';               }               echo $tr_table;           }        }else{            \ErrorMessage::JsonResponse(false, 'Sorry, the Student ID you entered does not exist in our records. Please check and try again.');        }    }}if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])){    match ($_POST['action']){        'store' => (new bookingController())->storeBooking(),        'filter' => (new bookingController())->filterByStudentId(),        default => http_response_code(400)    };}