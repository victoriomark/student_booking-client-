<?phpnamespace model;require_once  '../../config/Connection.php';require_once  '../../Helper/ErrorMessage.php';use Exception;use ErrorMessage;class announcement extends \Connection{ public function store(string $title, $des):void {     try {         $query = "INSERT INTO announcement( title, des) VALUES (?,?)";         $stmt = $this->Connect()->prepare($query);         if (!$stmt){             \ErrorMessage::JsonResponse(false,'Failed to prepare Statement');             return;         }         $stmt->bind_param('ss',$title,$des);         if ($stmt->execute()){             \ErrorMessage::JsonResponse(true ,'Successfully ');         }     }catch (Exception $e){         error_log('Error' . $e->getMessage());     } }    public function showAll():array    {        try {            $result = $this->Connect()->query("SELECT * FROM announcement");            $data = [];            if ($result->num_rows > 0){                while ($row = $result->fetch_assoc()){                    $data[] = $row;                }                return $data;            }        }catch (Exception $e){            error_log('Error'. $e->getMessage());        }        return [];    }    public function update(string $title , string $des, int $id):void    {        try {            $query = "UPDATE announcement SET title = ?, des = ? WHERE id = ?";            $stmt = $this->Connect()->prepare($query);            if (!$stmt){                \ErrorMessage::JsonResponse(false,'Failed to Prepared Statement');            }            $stmt->bind_param('ssi',$title,$des,$id);            if ($stmt->execute()){                ErrorMessage::JsonResponse(true,'Announcement is Successfully Updated');            }        }catch (Exception $e){            error_log('Error'. $e->getMessage());        }    }    public  function delete(int $id):void    {        try {            $query = "DELETE FROM announcement WHERE id = ?";            $stmt = $this->Connect()->prepare($query);            if (!$stmt){                \ErrorMessage::JsonResponse(false,'Failed to Prepared Statement');            }            $stmt->bind_param('i',$id);            if ($stmt->execute()){                ErrorMessage::JsonResponse(true,'Announcement is Successfully Deleted');            }        }catch (Exception $e){            error_log('Error'. $e->getMessage());        }    }    public function CountAnnouncement(): int    {        try {            $query = "SELECT COUNT(*) AS total_announcement FROM announcement";            $result = $this->Connect()->query($query);            if ($result) {                $row = $result->fetch_assoc();                return (int) $row['total_announcement'];            }        }catch (Exception $e){            error_log('Error' .$e->getMessage());        }        return 0; // Default kung may error    }}