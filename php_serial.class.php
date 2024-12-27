<?php

class phpSerial
{
    private $_device;
    private $_dState = null;
    private $_os = null;
    private $_windevice = null;
    private $_deviceHandle;

    const SERIAL_DEVICE_OPENED = 1;
    const SERIAL_DEVICE_SET = 2;

    public function __construct()
    {
        $this->_os = strtolower(php_uname('s'));
    }

    // Method to set the serial device path
    public function deviceSet(string $device): bool
    {
        echo "Setting serial port: " . $device . "\n";  // Debug message

        if ($this->_dState !== self::SERIAL_DEVICE_OPENED) {
            if ($this->_os === "linux" || $this->_os === "osx") {
                // Handle Linux/macOS
                if (preg_match("@^COM(\d+):?$@i", $device, $matches)) {
                    $device = "/dev/ttyS" . ($matches[1] - 1);
                }

                if ($this->_exec("stty -F " . $device) === 0) {
                    $this->_device = $device;
                    $this->_dState = self::SERIAL_DEVICE_SET;
                    return true;
                }
            } elseif ($this->_os === "windows") {
                // Windows handling: ensure COM port is in the correct format for Windows
                if (preg_match("@^COM(\d+):?$@i", $device, $matches)) {
                    $this->_windevice = "COM" . $matches[1];
                    $this->_device = "\\\\.\\COM" . $matches[1];  // Correct format for Windows
                    $this->_dState = self::SERIAL_DEVICE_SET;
                    return true;
                }
            }

            trigger_error("Specified serial port is not valid", E_USER_WARNING);
            return false;
        } else {
            trigger_error("You must close your device before setting another one", E_USER_WARNING);
            return false;
        }
    }

    // Method to open the serial device
    public function deviceOpen(): bool
    {
        echo "Opening device: " . $this->_device . "\n";  // Debug message

        if ($this->_dState !== self::SERIAL_DEVICE_SET) {
            trigger_error("Device not set", E_USER_WARNING);
            return false;
        }

        // Handle opening the device based on OS
        if ($this->_os === "windows") {
            // Try opening the COM port on Windows
            $this->_handleWindowsOpen();
        } else {
            // Handle other OS like Linux/OSX
            $this->_handleUnixOpen();
        }

        $this->_dState = self::SERIAL_DEVICE_OPENED;
        return true;
    }

    // Handle Windows-specific port opening
    private function _handleWindowsOpen()
    {
        $this->_deviceHandle = fopen($this->_device, 'r+');
        if ($this->_deviceHandle === false) {
            trigger_error("Unable to open the serial port on Windows", E_USER_WARNING);
            return false;
        }
    }

    // Handle Unix-based systems (Linux/macOS) for opening the port
    private function _handleUnixOpen()
    {
        $this->_deviceHandle = fopen($this->_device, "r+");
        if (!$this->_deviceHandle) {
            trigger_error("Unable to open the serial port on Linux/OSX", E_USER_WARNING);
            return false;
        }
    }

    // Method to configure the baud rate
    public function confBaudRate(int $baudRate): bool
    {
        echo "Setting baud rate: " . $baudRate . "\n";  // Debug message

        if ($this->_dState !== self::SERIAL_DEVICE_OPENED) {
            trigger_error("Device must be opened before setting baud rate", E_USER_WARNING);
            return false;
        }

        // Validate the baud rate
        if (!in_array($baudRate, [9600, 19200, 38400, 57600, 115200])) {
            trigger_error("Invalid baud rate: " . $baudRate, E_USER_WARNING);
            return false;
        }

        // If Windows, baud rate setting is not implemented, so display a warning
        if ($this->_os === "windows") {
            trigger_error("Baud rate configuration on Windows is not implemented in this class", E_USER_WARNING);
            return false;
        }

        // Set baud rate for Unix-based systems using stty
        if ($this->_os === "linux" || $this->_os === "osx") {
            $cmd = "stty -F " . $this->_device . " " . $baudRate;
            return ($this->_exec($cmd) === 0);
        }

        return false;
    }

    // Helper function to execute system commands
    private function _exec($command)
    {
        return shell_exec($command);
    }

    // Method to close the device
    public function deviceClose()
    {
        echo "Closing device...\n";  // Debug message
        if ($this->_dState === self::SERIAL_DEVICE_OPENED) {
            fclose($this->_deviceHandle);
            $this->_dState = null;
        }
    }

    // Read data from the serial port (implement this if needed)
    public function readPort($bytes = 1)
    {
        echo "Reading from device...\n";  // Debug message
        if ($this->_dState !== self::SERIAL_DEVICE_OPENED) {
            trigger_error("Device must be opened before reading", E_USER_WARNING);
            return false;
        }

        return fread($this->_deviceHandle, $bytes);
    }
}

// Usage example
$serial = new phpSerial();

// Set the serial port (make sure this is correct)
$serial->deviceSet("\\\\.\\COM6");  // Use the correct format for Windows

// Open the device
if ($serial->deviceOpen()) {
    // Set the baud rate after the device is opened
    $serial->confBaudRate(9600);

    // Read data
    $data = $serial->readPort(10);
    echo "Received data: " . $data;

    // Close the device after use
    $serial->deviceClose();
}
?>
