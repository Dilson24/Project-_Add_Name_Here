<?php
class AdminModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function showAllUsers()
    {
        $stmt = $this->conn->prepare('SELECT * FROM user');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function deleteUser($userId)
    {
        $stmt = $this->conn->prepare('DELETE FROM user WHERE User_ID = :userId');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function updateUserData($userId, $name, $lastName, $dateOfBirth, $phoneNumber, $studentType, $country, $city) {
        // Crear una cadena para almacenar las cláusulas SET de la consulta UPDATE
        $updateFields = "";
    
        // Verificar cada campo y agregarlo a la cadena si tiene un valor
        if ($name) {
            $updateFields .= "Name = :name, ";
        }
        if ($lastName) {
            $updateFields .= "Last_Name = :lastName, ";
        }
        if ($dateOfBirth) {
            $updateFields .= "Date_of_Birth = :dateOfBirth, ";
        }
        if ($phoneNumber) {
            $updateFields .= "Phone_Number = :phoneNumber, ";
        }
        if ($studentType) {
            $updateFields .= "Student_Type_ID = :studentType, ";
        }
        if ($country) {
            $updateFields .= "Country = :country, ";
        }
        if ($city) {
            $updateFields .= "City = :city, ";
        }
    
        // Eliminar la coma y el espacio final de la cadena
        $updateFields = rtrim($updateFields, ", ");
    
        // Verificar si se proporcionaron datos para actualizar
        if (!empty($updateFields)) {
            // Consulta SQL para actualizar los datos del usuario
            $sql = "UPDATE user SET $updateFields WHERE User_ID = :userId";
    
            $stmt = $this->conn->prepare($sql);
    
            // Vincular los parámetros
            $stmt->bindParam(':userId', $userId);
            if ($name) $stmt->bindParam(':name', $name);
            if ($lastName) $stmt->bindParam(':lastName', $lastName);
            if ($dateOfBirth) $stmt->bindParam(':dateOfBirth', $dateOfBirth);
            if ($phoneNumber) $stmt->bindParam(':phoneNumber', $phoneNumber);
            if ($studentType) $stmt->bindParam(':studentType', $studentType);
            if ($country) $stmt->bindParam(':country', $country);
            if ($city) $stmt->bindParam(':city', $city);
    
            if ($stmt->execute()) {
                return true; // Actualización exitosa
            } else {
                return false; // Error al actualizar
            }
        } else {
            return false; // No se proporcionaron datos para actualizar
        }
    }
    
    

    
}
?>