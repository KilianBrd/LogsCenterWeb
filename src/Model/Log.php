<?php 
namespace Src\Model;

require_once __DIR__ . '/Database.php';

class Log {
    private $id;
    private $receivedAt;
    private $facility;
    private $priority;
    private $fromHost;
    private $syslogTag;
    private $message;
    private $severity;
    private $eventTime;
    
    public function __construct($id, $receivedAt, $facility, $priority, $fromHost, $syslogTag, $message, $severity, $eventTime) {
        $this->id = $id;
        $this->receivedAt = $receivedAt;
        $this->facility = $facility;
        $this->priority = $priority;
        $this->fromHost = $fromHost;
        $this->syslogTag = $syslogTag;
        $this->message = $message;
        $this->severity = $severity;
        $this->eventTime = $eventTime;
    }

    public function getId () {
        return $this->id;
    }
    
    public function getReceivedAt () {
        return $this->receivedAt;
    }
    public function getFacility () {
        return $this->facility;
    }
    public function getPriority () {
        return $this->priority;
    }
    public function getFromHost () {
        return $this->fromHost;
    }
    public function getSyslogTag () {
        return $this->syslogTag;
    }
    public function getMessage () {
        return $this->message;
    }
    public function getSeverity () {
        return $this->severity;
    }
    public function getEventTime () {
        return $this->eventTime;
    }
    public function getEventTimeFormatted () {
        if (!$this->eventTime) return '-';
        $dt = new \DateTime($this->eventTime);
        return $dt->format('d/m/Y H:i:s');
    }
    public function getReceivedAtFormatted () {
        if (!$this->receivedAt) return '-';
        $dt = new \DateTime($this->receivedAt);
        return $dt->format('d/m/Y H:i:s');
    }
    public function setId ($id) {
        $this->id = $id;
    }
    public function setReceivedAt ($receivedAt) {
        $this->receivedAt = $receivedAt;
    }
    public function setFacility ($facility) {
        $this->facility = $facility;
    }
    public function setPriority ($priority) {
        $this->priority = $priority;
    }

    public function setFromHost ($fromHost) {
        $this->fromHost = $fromHost;
    }
    public function setSyslogTag ($syslogTag) {
        $this->syslogTag = $syslogTag;
    }
    public function setMessage ($message) {
        $this->message = $message;
    }
    public function setSeverity ($severity) {
        $this->severity = $severity;
    }
    public function setEventTime ($eventTime) {
        $this->eventTime = $eventTime;
    }

    public function getAllLogs() {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare('SELECT * FROM systemevents');
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = new Log($row['id'], $row['received_at'], $row['facility'], $row['priority'], $row['from_host'], $row['syslog_tag'], $row['message'], $row['severity'], $row['event_time']);
        }
        return $logs;
    }


}