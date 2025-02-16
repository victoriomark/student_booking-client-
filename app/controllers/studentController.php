<?phpnamespace controllers;use model\student;require_once  '../model/student.php';require_once  '../../Helper/ErrorMessage.php';class studentController{   public function storeStudent():void   {       $Fields = [           'f_name' => 'first name is required',           'l_name' =>  'last name is required',           'm_middle' =>  'birthday date name is required',           's_email' => 'email address is required',           'student_id'  => 'student Id is required',       ];       $data = [];       $error = [];       foreach($Fields as $Field => $message){           if (!isset($_POST[$Field]) || trim($_POST[$Field]) === '') { // check if each input is Empty or no value               $error[$Field] = $message;           }else{               $data[$Field] = htmlspecialchars($_POST[$Field]);           }       }       if (!empty($error)) { // check if the error array is not empty           $data['success'] = false;           $data['errors'] = $error;           echo json_encode($data);           return;       }       $student = new student();       if (!$student->studentIdChecker($data['student_id'])){           $student->store(               $data['student_id'],               $data['f_name'],               $data['l_name'],               $data['s_email'],               $data['m_middle']           );       }else{           \ErrorMessage::JsonResponse(false, 'Apologies, but that student ID is already in use. Kindly provide a different one.');       }   }    public static function displayToTable():void    {        $students = new student();        $trTable = '';        $data = $students->showAll();        if ($data) {            foreach ($data as $row){                $trTable .= '            <tr>               <th>'.$row['id'].'</th>                <td>'.$row['f_name'].'</td>                <td>'.$row['l_name'].'</td>                <td>'.$row['middle_name'].'</td>                <td>'.$row['email'].'</td>                <td>'.$row['studentId'].'</td>                <td>                    <button class="btn btn-danger btn_delete" value="'.$row['id'].'">Delete</button>                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal_'.$row['id'].'">Edit</button>                </td>            </tr>            <!-- Modal for this student -->            <div class="modal fade" id="editModal_'.$row['id'].'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">                <div class="modal-dialog modal-dialog-centered">                    <div class="modal-content">                        <div class="modal-header">                            <h1 class="modal-title fs-5">Update Student</h1>                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                        </div>                        <form class="update_studentModal" id="updateStudentForm_'.$row['id'].'">                            <div class="modal-body">                                <input type="hidden" name="student_id" value="'.$row['id'].'">                                <div class="form-floating mb-3">                                    <input type="text" class="form-control" name="f_name" value="'.$row['f_name'].'" placeholder="First Name" required>                                    <label>First Name</label>                                </div>                                <div class="form-floating mb-3">                                    <input type="text" class="form-control" name="l_name" value="'.$row['l_name'].'" placeholder="Last Name" required>                                    <label>Last Name</label>                                </div>                                <div class="form-floating mb-3">                                    <input type="text" class="form-control" name="middle_name" value="'.$row['middle_name'].'" placeholder="Middle Name" required>                                    <label>Middle Name</label>                                </div>                                <div class="form-floating mb-3">                                    <input type="email" class="form-control" name="email" value="'.$row['email'].'" placeholder="Email" required>                                    <label>Email</label>                                </div>                                <div class="form-floating mb-3">                                    <input type="text" class="form-control" name="studentId" value="'.$row['studentId'].'" placeholder="Student ID" required>                                    <label>Student ID</label>                                </div>                                <input type="hidden" name="id" value="'.$row['id'].'">                            </div>                            <div class="modal-footer">                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                                <button type="submit" class="btn btn-primary">Save Changes</button>                            </div>                        </form>                    </div>                </div>            </div>';            }            echo $trTable;        }    }    public  function update():void    {        $f_name = htmlspecialchars($_POST['f_name']);         $l_name = htmlspecialchars($_POST['l_name']);         $middle_name = htmlspecialchars($_POST['middle_name']);         $email = htmlspecialchars($_POST['email']);         $studentId = htmlspecialchars($_POST['studentId']);         $Id = htmlspecialchars($_POST['id']);         $student = new student();        $student->update(            $studentId,            $f_name,            $l_name,            $email,            $middle_name,            $Id        );    }    public function delete():void    {        $id = htmlspecialchars($_POST['id']);        if (empty($id)){            \ErrorMessage::JsonResponse(false, 'No Id provided');            return;        }        $student = new student();        $student->delete($id);    }}if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])){    match ($_POST['action']){        'store' => (new studentController())->storeStudent(),        'update' => (new studentController())->update(),        'delete' => (new studentController())->delete(),        default => http_response_code(400)    };}