using System;
using System.Collections.Generic;
using System.IO.Ports;
using System.Text;
using System.Windows.Forms;

// Class handling all interactions with COM/Serial Ports

namespace ComputerToArduino
{
    public class PortsHandler
    {
        private string[] portsNames;
        private SerialPort port;
        private ComboBox portsBox;
        private static int PortBoundRate = 9600;
        private static int arduinoAnswerWaitingTime = 40;
        // Cunstructor need ComboBox for adding the scaned ports to display
        public PortsHandler(ComboBox portsBox)
        {
            PortsBox = portsBox;
            PortsNames = SerialPort.GetPortNames();
            portsToBox();           
        }

        public string[] PortsNames // Store all scaned ports names
        {
            get
            {
                return portsNames;
            }
            set
            {
                if (value != null)
                    portsNames = value;
            }
        }
        public ComboBox PortsBox // ComboBox to display and select from ports
        {
            get
            {
                return portsBox;
            }
            set
            {
                portsBox = value;
            }
        }
        public SerialPort Port // Port to be connected to
        {
            get
            {
                return port;
            }
            set
            {
                port = value;
            }
        }

        // Function adding all scaned ports name to ComboBoxs
        private void portsToBox()
        {
            foreach (string port in PortsNames)
            {
                PortsBox.Items.Add(port);
                if (PortsNames[0] != null)
                    PortsBox.SelectedItem = PortsNames[0];
            }
        }

        // Function deleating last scanned ports
        // and scanning again
        public void PortsRefresh()
        {
            PortsNames = null;
            PortsBox.Items.Clear();
            PortsBox.Text = "";
            PortsNames = SerialPort.GetPortNames();
            portsToBox();
        }

        // Function connectin to given port in "portName".
        // PortBoundRate initialized as static class int 
        // Function enabling/disabling Ports ComboBox depending on connection success
        public bool connectToPort(string portName)
        {
            try
            {
                Port = new SerialPort(portName, PortBoundRate, Parity.None, 8, StopBits.One);
                Port.Open();
                PortsBox.Enabled = false;
                return Port.IsOpen;
            }
            catch (Exception)
            {
                PortsBox.Enabled = true ;
                return false;
            }
        }

        // Function disconnecting from connected port
        public void disconnectFromPort()
        {
            Port.Close();
        }

        // Function reading answer from arduino.
        // If data_rx get "OKEY" from connected port (arduino) -> arduino seccesfuly connected to WIFI and get validation from DB
        // If data_rx get "FALSE" arduino -> failed to connect
        // If "arduinoAnswerWaitingTime" (20) passed -> no anser from arduino
        // All the cases stop the reading loop
        private void AnsRead()
        {
            if (Port.IsOpen)
            {
                List<string> arrey = new List<string>();
                Port.DiscardInBuffer();
                DateTime now = DateTime.Now;
                DateTime prev = now;
                string data_rx = "";
                while (true)           // reading loop
                {
                    System.Threading.Thread.Sleep(200);
                    if (now > prev.AddSeconds(arduinoAnswerWaitingTime))
                        throw new Exception(MAT.NoAns());
                    try
                    {
                        data_rx = Port.ReadExisting();
                        arrey.Add(data_rx);
                    }
                    catch (Exception)
                    {
                        throw new Exception(MAT.NoAns());
                    }
                    if (data_rx.Contains("OKEY"))
                        break;
                    else if (data_rx.Contains("FALSEser"))
                        throw new Exception(MAT.WrFail());
                    else if (data_rx.Contains("FALSEwifi"))
                        throw new Exception(MAT.WIFIfaile());
                    else if (data_rx.Contains("FALSEuser"))
                        throw new Exception(MAT.USERfaile());
                    now = DateTime.Now;
                }
                MAT.Secssed();
            }
            else
            {
                throw new Exception(MAT.NoAns());
            }
        }

        // Function writing to connected port given massege "MessageToWrite"
        // waiting 2 sec and trying to read an answer from the port,
        // AnsRead() on failer trowing an exception with needed massege.
        public bool writeToPort(string MessageToWrite)
        {
            try
            {
                Port.Write(MessageToWrite);
                System.Threading.Thread.Sleep(2000);
                AnsRead();
                return true;
            }
            catch (Exception e)
            {
                MAT.MessBox(e.Message);
                return false;
            }
        }
    }
}
