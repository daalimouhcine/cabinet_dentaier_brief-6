<?php

    // Set the API for patient to be called
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json ; charset=utf-8');
    header("Access-Control-Allow-Methods:*"); 
    header("Access-Control-Max-Age: 600");
    header("Access-Control-Allow-Headers:*");
    
    class Appointments extends Controller {

        public function __construct() {
            $this->appointmentModel = $this->model('Appointment');
        }


        // Get all appointments by patient id
        public function getAll($patientId) {
            $appointments = $this->appointmentModel->getAll($patientId);
            if($appointments) {
                echo json_encode($appointments);
            } else {
                echo json_encode(['message' => 'No appointments found']);
            }
        }
 
        // create appointment
        public function create() {
            // get the data from the POST
            $data = json_decode(file_get_contents('php://input'), true);
            // create the appointment
            if($this->appointmentModel->createA($data)) {
                echo json_encode(['message' => 'Appointment created']);
            } else {
                echo json_encode(['message' => 'Appointment not created']);
            }
        }

        public function getByIdOrDate( $data = '' ) {
            if(empty($data)) {
                echo json_encode(['error' => 'No data provided']);
            } else if(str_contains($data, 'patient_')) {
                echo json_encode($this->appointmentModel->getByIdOrDate($data, ''));
            } else {
                echo json_encode($this->appointmentModel->getByIdOrDate('', $data));
            }    
        }

        public function updateA() {
            $data = json_decode(file_get_contents('php://input'), true);
            if($this->appointmentModel->updateA($data)) {
                echo json_encode(['message' => 'Appointment updated']);
            } else {
                echo json_encode(['message' => 'Appointment not updated']);
            }
        }

        public function delete($appointmentId, $patientId) {
            if($this->appointmentModel->deleteA($appointmentId, $patientId)) {
                echo json_encode(['message' => 'Appointment deleted']);
            } else {
                echo json_encode(['message' => 'Appointment not deleted']);
            }
        }

}